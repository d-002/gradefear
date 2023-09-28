function init() {
	initLogin(() => {
	if (isLoggedIn()) {
		let div = document.getElementById("buttons");
		div.children[0].innerHTML = "Dashboard";
		div.children[0].href = "/dashboard";
		div.children[1].innerHTML = "Enter new grade";
		div.children[1].href = "/newgrade";
	}
	});
}