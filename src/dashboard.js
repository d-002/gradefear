let lastGrades, info, names;

function logout() {
	localStorage.removeItem("login");
	localStorage.removeItem("pwd");
	document.location.href = "..";
}

function clear() {
	localStorage.removeItem(login);
}

function deleteProfile() {
	$.ajax({
		url: "../src/deleteProfile.php",
		method: "POST",
		data: {login: localStorage.getItem("login"), pwd: localStorage.getItem("pwd")},
		success: (error) => {
			if (error == 0) {
				console.log("success");
				clear();
				logout();
			} else console.error(error);
		}
	});
}

function parseNumber(string) {
	if (string.includes(".")) return parseInt(parseFloat(string)*100)/100;
	// todo: remove "/20"
	return parseInt(string);
}

function showStats(i) {
	// empty div
	let container = document.getElementById("last");
	while (container.children.length > 1) container.lastChild.remove();

	if (i >= names.length) {
		let p = document.createElement("p");
		p.innerHTML = "Nothing to display yet.";
		container.appendChild(document.createElement("br"));
		container.appendChild(p);
	} else {
		let denom = " / "+info[names[i]][0];
		let top = parseInt(info[names[i]][2]/info[names[i]][3]*100);
		let len = info[names[i]][3];
		let rank = getRank(info[names[i]][2]/len - 1/len);
		let comment = getComment(len);
		let test = names[i].split("/");

		[["Test", test[2]+" (class: "+test[0]+", date: "+test[1]+")"],
		["Grade", lastGrades[names[i]]+denom],
		["Class average", info[names[i]][1]],
		["Ranking", "<span class="+rank+">"+rank+"</span> ("+info[names[i]][2]+" / "+len+")"],
		["Top", top+"% ("+comment+")"]].forEach((ab) => {
			let div = document.createElement("div");
			div.className = "line";
			div.innerHTML = "<strong>"+ab[0]+"</strong><p>"+ab[1]+"</p>";
			container.appendChild(document.createElement("br"));
			container.appendChild(div);
		});
	}
}

function getRank(x) {
	if (x < 0.05) return "S";
	if (x < 0.2) return "A";
	if (x < 0.4) return "B";
	if (x < 0.6) return "C";
	if (x < 0.75) return "D";
	if (x < 0.9) return "E";
	return "F";
}

function getComment(len) {
	if (len < 5) return "<strong>very unprecise<strong>";
	if (len < 10) return "<strong>unprecise<strong>";
	if (len < 20) return "moderately precise";
	if (len < 30) return "precise";
	return "very precise";
}

function fillStats() {
	function getInfo() {
		if (queue.length == 0) {
			callback();
		} else {
			let name = queue.pop(0);
			$.get({url: "/classes/"+name, success: (data) => {
				data = data.split("\n");
				let len = data.length-1;
				let average = 0;
				let values = [];
				for (let i = 1; i <= len; i++) {
					values.push(parseNumber(data[i]));
					average += values[values.length-1];
				}
				values.sort((a, b) => {if (a < b) return 1; if (a == b) return 0; return -1;});
				let rank;
				let min = values[0];
				let max = min;
				for (let i = 0; i < len; i++) {
					if (values[i] == lastGrades[name] && rank == null) {
						rank = i+1;
					}
					if (values[i] > max) max = values[i];
					if (values[i] < min) min = values[i];
				}
				average = parseInt(average/len*100)/100;
				info[name] = [parseNumber(data[0]), average, rank, len, max, min];

				// get next grade info
				getInfo();
			}});
		}
	}

	function callback() {
		// sort to only keep the latest grades
		function compare(a, b) {
			let d1 = Date.parse(a.split("/")[1]);
			let d2 = Date.parse(b.split("/")[1]);
			if (d1 < d2) return 1;
			if (d1 > d2) return -1;
			return 0;
		}
		names.sort(compare);

		// after everything is loaded, display elements on screen

		// show last grade and full statistics
		showStats(0);

		// show last grades
		container = document.getElementById("lasts");
		for (let i = 0; i < names.length; i++) {
			if (i >= 5) break;
			container.appendChild(document.createElement("br"));
			let a = document.createElement("a");
			let grade = lastGrades[names[i]];
			let name = names[i].split("/");
			a.className = "line";
			a.href = "javascript:showStats("+i+")";
			a.innerHTML = "<p>"+name[2]+" ("+name[1]+")</p><p>"+lastGrades[names[i]]+" / "+info[names[i]][0]+"</p>";
			container.appendChild(a);
		}

		// show chart statistics for last grades
		let ctx = document.getElementsByTagName("canvas")[0].getContext("2d");
		let colors = ["#55f", "#777", "rgba(0, 0, 0, 0.2)"]; // own, others, fill
		ctx.lineWidth = 1;
		ctx.font = "calibri 16";
		for (let i = 0; i < 2; i++) {
			ctx.strokeStyle = ctx.fillStyle = ["#333", "#a00"][i];
			ctx.beginPath();
			ctx.moveTo(0, 20+40*i);
			ctx.lineTo(400, 20+40*i);
			ctx.stroke();
			ctx.fillText(["100%", "50%"][i], 2, 30+40*i);
		}
		ctx.fillStyle = colors[2];
		ctx.lineWidth = 2;
		let prevY, y; // [grade, average, min, max]
		for (let i = 0; i < names.length; i++) {
			if (i >= 20) break;
			let x = 395-19*i;
			I = info[names[i]];
			let m = 80/I[0];
			y = [100-lastGrades[names[i]]*m, 100-I[1]*m, 100-I[4]*m, 100-I[5]*m];

			let _x;
			if (prevY == null) {
				prevY = y;
				_x = x+5;
			} else _x = x+19;

			ctx.strokeStyle = colors[1];
			ctx.beginPath();
			ctx.moveTo(_x, prevY[2]);
			ctx.lineTo(x, y[2]);
			ctx.lineTo(x, y[3]);
			ctx.lineTo(_x, prevY[3]);
			ctx.fill();

			for (let j = 1; j >= 0; j--) {
				ctx.strokeStyle = colors[j];
				ctx.beginPath();
				ctx.moveTo(_x, prevY[j]);
				ctx.lineTo(x, y[j]);
				ctx.stroke();
			}
			prevY = y;
		}

		// chart legend
		ctx.strokeStyle = "#aaa";
		ctx.beginPath();
		ctx.moveTo(0, 100);
		ctx.lineTo(400, 100);
		ctx.stroke();
		ctx.fillStyle = "#eee";
		ctx.beginPath();
		ctx.moveTo(0, 150);
		ctx.lineTo(0, 100);
		ctx.lineTo(400, 100);
		ctx.lineTo(400, 150);
		ctx.fill();
		for (let i = 0; i < 3; i++) {
			let x = [20, 150, 300][i];
			let y = 128;
			if (i == 2) {
				ctx.fillStyle = colors[2];
				ctx.beginPath();
				ctx.moveTo(x, y);
				ctx.lineTo(x+20, y);
				ctx.lineTo(x+20, y-7);
				ctx.lineTo(x, y-7);
				ctx.fill();
			} else {
				ctx.strokeStyle = colors[i];
				ctx.beginPath();
				ctx.moveTo(x, y-3);
				ctx.lineTo(x+20, y-3);
				ctx.stroke();
			}
			ctx.fillStyle = "black";
			ctx.fillText(["You", "Class average", "Grades range"][i], x+30, y);
		}
	}

	// get grades from localStorage
	lastGrades = {};
	let storage = JSON.parse(localStorage.getItem(login));
	if (storage == null) storage = {};
	Object.keys(storage).forEach((key) => {
		if (key == "login" || key == "pwd") return;
		lastGrades[key] = parseNumber(storage[key]);
	});
	names = Object.keys(lastGrades);

	// get grades info (max grade, average, number of entries)
	// recursively and asynchronously whyyyy
	info = {};
	let queue = [...names];
	if (queue.length) {
		getInfo();
	} else {
		info = {};
		callback(); // handle no recorded grades
	}
}

function init() {
	initLogin(() => {
	if (isLoggedIn()) {
		document.getElementsByTagName("h1")[0].innerHTML += login;
	} else {
		document.location.href = "/login";
	}
	fillStats();
	});
}