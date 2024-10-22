
<style>
    .active{
        color: #2A6092 !important;
        font-size: 16px;
        font-weight: bold;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark">
    {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item ">
            <a href="{{ route('single.fan.buy.posts',$fan->id) }}"
                class="{{  Route::currentRouteNamed('single.fan.buy.posts') ? "nav-link active" : "nav-link"}}"  >Buy Content</a>
        </li>
        {{-- <li class="nav-item ">
            <a href="{{route('single.celebrity.shops',$fan->id)}}"
                class="{{  Route::currentRouteNamed('single.celebrity.shops') ? "nav-link active" : "nav-link"}}">Shops Items</a>
        </li> --}}
        <li class="nav-item dropdown">
            <a class="{{  Route::currentRouteNamed('single.fan.offers.to.celebrity') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('single.fan.offers.from.celebrity') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Offers
              <b class="caret d-none d-lg-block d-xl-block"></b>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.fan.offers.to.celebrity',$fan->id) }}">Fan Offers To Celebrity</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.fan.offers.from.celebrity',$fan->id) }}">Fan offers From Celebrity</a>
              <div class="dropdown-divider"></div>
              {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
        </li>

        <li class="nav-item">
            <a class="{{  Route::currentRouteNamed('single.fan.subscription') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
               href="{{ route('single.fan.subscriptions',$fan->id) }}">Buy Subscription</a>
        </li>
        <li class="nav-item dropdown">
            <a class="{{  Route::currentRouteNamed('fan.block.users') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('fan.report.users') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('fan.follower') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('fan.following') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage Users
              <b class="caret d-none d-lg-block d-xl-block" style="left: 90%;"></b>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('fan.block.users',$fan->id) }}">Blocked Users</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('fan.report.users',$fan->id) }}">Reported Users</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('fan.follower',$fan->id) }}">Followers</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('fan.following',$fan->id) }}">Followings</a>
              {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('celebrity.block.users',$fan->id) }}"
                class="{{  Route::currentRouteNamed('celebrity.block.users') ? "nav-link active" : "nav-link"}}">Blocked User</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.report.users',$fan->id) }}"
                class="{{  Route::currentRouteNamed('celebrity.report.users') ? "nav-link active" : "nav-link"}}">Reported User</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.follower',$fan->id) }}"
            class="{{ Route::currentRouteNamed('celebrity.follower') ? "nav-link active" : "nav-link" }}">Followers</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.following',$fan->id) }}"
            class="{{ Route::currentRouteNamed('celebrity.following') ? "nav-link active" : "nav-link" }}">Followings</a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('fan.orders',$fan->id) }}"
            class="{{ Route::currentRouteNamed('fan.orders') ? "nav-link active" : "nav-link" }}">Orders</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('fan.transection.logs',$fan->id) }}"
                class="{{ Route::currentRouteNamed('fan.transection.logs') ? "nav-link active" : "nav-link" }}">Transaction Details</a>
        </li>
      </ul>
    </div>
</nav>
