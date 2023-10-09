function news() {
	let div = document.getElementById("news");
	$.get({
		url: "news/news.txt",
		success: (data) => {
			let lines = [];
			data.split("\n").forEach((line) => { lines.push(line.split(";")) });
			let i = parseInt(Math.random()*lines.length);
			console.log(lines);

			// display a random news
			div.innerHTML = "<p>News: "+lines[i][0]+'</p><a href="'+lines[i][1]+'"><img src="news/'+lines[i][2]+'"></a>';
		}
	});
}

function init() {
	news();
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