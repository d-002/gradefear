let users = {};

function getUsers(then) {
	$.get("/users", function(data) {
		let lines = data.split("\n");
		for (let i = 0; i < lines.length; i++) {
			if (lines[i] == "") { continue; }
			let j = lines[i].indexOf(" ");
			users[lines[i].substring(0, j)] = lines[i].substring(j+1);
		}
		then();
	}, 'text');
}

function encode(s) {
	let newS = "";
	let x = 0;
	s.split("").forEach((char) => {newS += (x += (char.charCodeAt(0)*4477375789) % 1048576).toString()});
	return newS;
}

function isLoggedIn() {
	// get ID and encoded key in cookies
	login = localStorage.getItem("login");
	pwd = localStorage.getItem("pwd");
	return (login != null && users[login] == encode(pwd));
}

function initLogin(then) {
	// get list of registered users
	getUsers(then);
}
