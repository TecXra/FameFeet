
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
            <a href="{{ route('single.celebrity.posts',$celebrity->id) }}"
                class="{{  Route::currentRouteNamed('single.celebrity.posts') ? "nav-link active" : "nav-link"}}"  >Posts</a>
        </li>
        <li class="nav-item ">
            <a href="{{route('single.celebrity.shops',$celebrity->id)}}"
                class="{{  Route::currentRouteNamed('single.celebrity.shops') ? "nav-link active" : "nav-link"}}">Shops Items</a>
        </li>
        <li class="nav-item dropdown">
            <a class="{{  Route::currentRouteNamed('single.celebrity.offers') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('single.celebrity.offers.to.fan') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Offers
              <b class="caret d-none d-lg-block d-xl-block"></b>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.celebrity.offers',$celebrity->id) }}">Fan Offers</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.celebrity.offers.to.fan',$celebrity->id) }}">Celebrity Offers</a>
              <div class="dropdown-divider"></div>
              {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
        </li>

        {{-- <li class="nav-item">
            <a href="{{ route('single.celebrity.offers',$celebrity->id) }}"
               >Offers</a>
        </li> --}}
        <li class="nav-item dropdown">
            <a class="{{  Route::currentRouteNamed('single.celebrity.subscriptions') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('single.celebrity.subscribe.users') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Subscription
              <b class="caret d-none d-lg-block d-xl-block" style="left: 90%;"></b>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.celebrity.subscriptions',$celebrity->id) }}">Celebrity Subscriptions</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('single.celebrity.subscribe.users',$celebrity->id) }}">Subscribe Users</a>
              <div class="dropdown-divider"></div>
              {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="{{  Route::currentRouteNamed('celebrity.block.users') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('celebrity.report.users') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('celebrity.follower') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}
                      {{  Route::currentRouteNamed('celebrity.following') ? "nav-link dropdown-toggle active" : "nav-link dropdown-toggle"  }}"
                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage Users
              <b class="caret d-none d-lg-block d-xl-block" style="left: 90%;"></b>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('celebrity.block.users',$celebrity->id) }}">Blocked Users</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('celebrity.report.users',$celebrity->id) }}">Reported Users</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('celebrity.follower',$celebrity->id) }}">Followers</a>
              <a class="dropdown-item" style="color: #2A6092; font-size: 16px;" href="{{ route('celebrity.following',$celebrity->id) }}">Followings</a>
              {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
            </div>
        </li>

        <li class="nav-item">
            <a href="{{ route('celebrity.orders',$celebrity->id) }}"
            class="{{ Route::currentRouteNamed('celebrity.orders') ? "nav-link active" : "nav-link" }}">Orders</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.redeem.requests',$celebrity->id) }}"
                class="{{ Route::currentRouteNamed('celebrity.redeem.requests') ? "nav-link active" : "nav-link" }}">Redeem</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.bank.accounts',$celebrity->id) }}"
                class="{{ Route::currentRouteNamed('celebrity.bank.accounts') ? "nav-link active" : "nav-link" }}">Accounts Details</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('celebrity.transection.logs',$celebrity->id) }}"
                class="{{ Route::currentRouteNamed('celebrity.transection.logs') ? "nav-link active" : "nav-link" }}">Transaction Details</a>
        </li>
      </ul>
    </div>
</nav>
