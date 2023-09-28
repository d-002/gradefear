function logout() {
	localStorage.removeItem("login");
	localStorage.removeItem("pwd");
	document.location.href = "..";
}

function clear() {
	let keys = Object.keys(localStorage);
	for (let i = 0; i < keys.length; i++) {
		if (keys[i] != "login" && keys[i] != "pwd") {
			localStorage.removeItem(keys[i]);
		}
	}
}

function deleteProfile() {
	alert("todo lol");
}

function init() {
	initLogin(() => {
	if (isLoggedIn()) {
		document.getElementsByTagName("h1")[0].innerHTML += login;
	} else {
		document.location.href = "/login";
	}
	});
}