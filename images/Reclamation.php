<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="d-flex justify-content-center">


<section class="container card shadow-lg m-4 p-4">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary rounded" >

  <div class="container d-flex justify-content-between">
    <div>
       <img src="images/Vichy-Simbolo.png"height="40"alt="logo vichy" loading="lazy"style="margin-top: -1px;"/>
    </div>
    
    <div>
      <div class="d-flex align-items-center">
        <button class="btn  btn-warning me-3e text-light px-3 me-2">log out</button>
        <button type="button" class="btn btn-danger me-3">fermer</button>
      </div>
    </div>
  
  </div>
</nav>
<h2 class="text-primary my-4">Demande une Reclamation</h2>


<form action="/reclamation" method="post" class="body card shadow-lg p-4">

  <div class="form-group  d-flex justify-content-center align-items-center">
    <div class="col-sm-2 col-form-label fs-4 text-primary">nom_complete</div>
    <div class="col-sm-10">
      <input type="text" class="form-control " placeholder="votre nom et prenom">
    </div>
  </div>
 
  <div class="form-group  mt-4 d-flex justify-content-center align-items-center">
    <div class="col-sm-2 col-form-label fs-4 text-primary">le probleme</div>

  
    <div class="col-sm-10">
   
    <select class="form-select fs-5" aria-label="Default select example">
    <option selected class="text-danger">menu de problémes</option>
   
 
    </select>
  
    </div>
   
  </div>


  <div class="form-group mt-4  d-flex justify-content-center align-items-center">
    <div class="col-sm-2 col-form-label fs-4 text-primary">descriotion</div>
    <div class="col-sm-10">
        <textarea name="" id=""  rows="10" class="form-control"  placeholder="entrez un description"></textarea>
    </div>
  </div>
<div class="btns d-flex justify-content-center gap-3">
<button class="btn btn-success mt-3 col-4">valider</button>
<button type="reset" class="btn btn-danger mt-3 col-4">annuler</button>
</div>
</form>

</section>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>