<div id="header">
			<div>
				<a href="/"><img src="/img/icon-home.png" /></a>
				<strong>GradeFear</strong>
			</div>
			<div></div>
			<script>
			let header = document.getElementById("header").children[1];
			let _templogin = localStorage.getItem("login");

			let p = document.createElement("p");
			if (_templogin == null) { p.innerHTML = "Not logged in" }
			else { p.innerHTML = "Logged in as " + _templogin }
			header.appendChild(p);

			if (_templogin != null) {
				let a = document.createElement("a");
				a.innerHTML = "Dashboard";
				a.href="/dashboard";
				a.className = "header-button";
				header.appendChild(a);
			}
			</script>
		</div>
<?php>
