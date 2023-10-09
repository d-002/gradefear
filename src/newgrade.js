let _forms;
let selects = [];
let entries = [];
let selection = [null, null, null];
let error, comment;

function msg(text, error) {
	if (error) comment.className = "error";
	else comment.className = "";
	comment.innerHTML = text;
	error.innerHTML = text;
}

function isValid(name) {
	if (name == "" || name == null) return false;
	// from stackoverflow.com/q/11100821
	return !/^(con|prn|aux|nul|((com|lpt)[0-9]))$|([<>:"\/\\|?*])|(\.|\s)$/ig.test(name);
}

function handleWrite(path, writetype, write, callback=()=>{}) {
	login = localStorage.getItem("login");
	pwd = localStorage.getItem("pwd");
	$.ajax({
		url: "/src/writefile.php",
		method: "POST",
		data: {"path": path, "writetype": writetype, "write": write, "login": login, "pwd": pwd},
		success: (error) => {
			if (error == 0) callback();
			else msg("Error in writefile call: "+error, 1);
		}
	});
}

function listDir(path, readtype, callback=()=>{}) {
	$.ajax({
		url: "/src/listdir.php",
		method: "POST",
		data: {"path": path, "readtype": readtype},
		success: (data) => {
			if (data.length == 1) {
				msg("Error in listdir call: "+data, 1);
			} else {
				callback(JSON.parse(data));
			}
		}
	});
}

function step1() {
	function after() {
		empty(1);
		openForm(1);
		fillTests();
	}

	selection[1] = entries[1].value;

	// reset everything (might be needed)
	openForm(0);
	selection[2] = null;

	let name = entries[0].value;
	if (name != "") {
		if (!isValid(name)) return msg("Invalid class name", 1);
		handleWrite("../classes/"+name, "d", "", () => {
			addOption(0, name);
			selects[0].value = name;
			selection[0] = name;
			after();
			msg("Class successfully created", 0);
		});
	} else if (isValid(selects[0].value)) {
		selection[0] = selects[0].value;
		after();
		msg("Class successfully selected", 0);
	}
	else msg("No class selected/created", 1);
}

function step2() {
	function after() {
		$.get({
			url: dir+"/"+selection[2],
			success: (data) => {
				entries[4].placeholder = "/"+data.split("\n")[0];
				openForm(2);
			}
		});
	}

	let dir = "../classes/"+selection[0]+"/"+selection[1];
	if (!isValid(selection[0]) || !isValid(selection[1])) {
		msg("Invalid previous selection", 1);
		return;
	}

	let name = entries[2].value;
	if (name != "" && entries[3].value != "" && entries[3].value != "0") {
		if (!isValid(name)) return msg("Invalid test name", 1);
		// creating a test: optionally create a folder and add a test file (needs to not exist)
		handleWrite(dir, "d", "", () => {
			listDir(dir, "f", (files) => {
				ok = true;
				for (let i = 0; i < files.length; i++) {
					if (files[i] == name) {
						ok = false;
						break;
					}
				}
				if (ok) {
					handleWrite(dir+"/"+name, "f", entries[3].value, () => {
						addOption(1, name);
						selects[1].value = name;
						selection[2] = name;
						msg("Test successfully created", 0);
						after();
					});
				} else return msg("This test already exists", 1);
			});
		});
	} else if (isValid(selects[1].value)) {
		selection[2] = selects[1].value;
		msg("Test successfully selected", 0);
		after();
	}
	else if (selects[1].value == "") return msg("No test selected", 1);
	else msg("Invalid test creating entries", 1);
}

function step3() {
	if (!isValid(selection[0]) || !isValid(selection[1]) || !isValid(selection[2]))
		return msg("Invalid previous selection", 1);
	if (entries[4].value == "") return msg("Invalid grade", 1);

	let path = selection[0]+"/"+selection[1]+"/"+selection[2];
	handleWrite("../classes/"+path, "f", "\n"+entries[4].value, () => {
		$.get({url: "/classes/"+path, success: (data) => {
			let maxValue = parseFloat(data.split("\n")[0]);
			msg("Grade successfully recorded", 0);

			let dict = JSON.parse(localStorage.getItem(login));
			if (dict == null) dict = {};
			dict[path] = entries[4].value;
			localStorage.setItem(login, JSON.stringify(dict));
			openForm(3);
		}});
	});
}

function empty(i) {
	// empty dropdown of index i
	let children = selects[i].children;
	for (let j = children.length-1; j >= 0; j--) {
		selects[i].remove(children[j]);
	}
}

function addOption(i, name) {
	let option = document.createElement("option");
	option.textContent = name;
	option.value = name;
	selects[i].appendChild(option);
}

function openForm(i) {
	for (let j = 0; j < 4; j++) {
		if (j < i) {
			_forms[j].className = "done";
			_forms[j].scrollTop = 0;
		}
		else if (j == i) _forms[j].className = "";
		else _forms[j].className = "closed";
	}
}

function fillClasses() {
	listDir("../classes", "d", (dirs) => {
		for (let j = 0; j < dirs.length; j++) {
			addOption(0, dirs[j]);
		}
	});
}

function fillTests(i) {
	listDir("../classes/"+selection[0], "d", (dirs) => {
		let ok = false;
		for (let i = 0; i < dirs.length; i++) {
			if (dirs[i] == selection[1]) {
				ok = true; // directory exists, can parse it
				break;
			}
		}
		if (ok) {
			listDir("../classes/"+selection[0]+"/"+selection[1], "f", (dirs) => {
				for (let j = 0; j < dirs.length; j++) {
					addOption(1, dirs[j]);
				}
			});
		}
	});
}

function init() {
	initLogin(() => {
		selects.push(document.getElementById("classes"));
		selects.push(document.getElementById("tests"));
		entries.push(document.getElementById("class"));
		entries.push(document.getElementById("date"));
		entries.push(document.getElementById("test"));
		entries.push(document.getElementById("max-grade"));
		entries.push(document.getElementById("grade"));
		_forms = document.getElementsByTagName("form");
		error = document.getElementById("error");
		comment = document.getElementById("comment");

		let d = new Date();
		entries[1].value = d.getFullYear()+"-"+("0"+(d.getMonth()+1)).slice(-2)+"-"+("0"+d.getDate()).slice(-2);
		fillClasses();
	});
}
