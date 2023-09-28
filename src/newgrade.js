let selects = [];
let entries = [];
let arrays = [[], []];
let selection = [null, null, null];
// todo: handle combo not loaded

function handleWrite(path, pathtype, write, callback=()=>{}) {
	login = localStorage.getItem("login");
	pwd = localStorage.getItem("pwd");
	$.ajax({
		url: "../src/writefile.php",
		method: "POST",
		data: {"path": path, "pathtype": pathtype, "write": write, "login": login, "pwd": pwd},
		success: (error) => {
			if (error == 0) callback();
			else console.error("Error in writefile call:", error);
		}
	});
}

function listDir(path, callback=()=>{}) {
	$.ajax({
		url: "../src/listdir.php",
		method: "POST",
		data: {"path": path},
		success: (data) => {
			if (data.length == 1) {
				console.error("Error in listdir call:", data);
			} else {
				callback(JSON.parse(data));
			}
		}
	});
}

function step1() {
	selection[1] = entries[1].value;

	name = entries[0].value;
	if (name != "") {
		handleWrite("../classes", "dd", name, () => {
			addOption(0, name);
			arrays[0].push(name);
			selects[0].value = name;
			selection[0] = name;
			fillSelect(1);
		});
	} else {
		selection[0] = selects[0].value;
		fillTests();
	}
}

function step2() {
	name = entries[2].value;
	if (name != "") {
		handleWrite("../classes/"+selection[0], "d", name, () => {
			addOption(1, name);
			arrays[1].push(name);
			selects[1].value = name;
			selection[2] = name;
		});
	} else {
		selection[2] = selects[1].value;
	}
}

function addOption(i, name) {
	let option = document.createElement("option");
	option.textContent = name;
	option.value = name;
	selects[i].appendChild(option);
}

function fillClasses() {
	listDir("../classes", (dirs) => {
		arrays[0] = dirs;
		for (let j = 0; j < dirs.length; j++) {
			addOption(0, dirs[j]);
		}
	});
}

function fillTests(i) {
	
}

function init() {
	initLogin(() => {
		selects.push(document.getElementById("classes"));
		selects.push(document.getElementById("tests"));
		entries.push(document.getElementById("class"));
		entries.push(document.getElementById("date"));
		entries.push(document.getElementById("test"));
		let d = new Date();
		entries[1].value = d.getFullYear()+"-"+("0"+(d.getMonth()+1)).slice(-2)+"-"+("0"+d.getDate()).slice(-2);
		fillClasses();
	});
}
