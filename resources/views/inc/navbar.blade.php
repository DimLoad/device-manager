<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			{{ config('app.name', 'Device Manager') }}
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">

			</ul>

			<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="/">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/devices">Devices</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/team-members">TeamMembers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" target="_blank" rel="noopener" href="https://github.com/DimLoad/device-manager">Source Code</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" target="_blank" rel="noopener" href="https://drive.google.com/open?id=1dZIdd2re7cVhZx5Hc06-1QIamm65o3xLNNWK6s1hvSE">Time spent</a>
					</li>
				</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
					<li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
					<li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
				@else
					<li><a class="nav-link" href="/dashboard">Dashboard</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								Logout
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				@endguest  
			</ul>
		</div>
	</div>
</nav>