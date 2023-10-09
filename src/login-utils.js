let users = {};
let login;
let encodedpwd;

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

function isLoggedIn() {
	// get ID and encoded key in cookies
	return (login != null && users[login] == encodedpwd);
}

function initLogin(then) {
	// get list of registered users
	getUsers(() => {
		// get login and encrypted password
		login = localStorage.getItem("login");
		$.ajax({
			url: "/src/encodepwd.php",
			method: "POST",
			data: {"pwd": localStorage.getItem("pwd")},
			success: (data) => {
				encodedpwd = data;
				then();
			}
		});
	});
}
