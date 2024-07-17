
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{route('dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <!-- <a class="nav-link collapsed" href="{{route('inbox')}}"> -->
        <a href="{{route('groups.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Group</span>
    </a>
  </li>
  <li class="nav-item">
    <!-- <a class="nav-link collapsed" href="{{route('inbox')}}"> -->
        <a href="{{route('consolidations.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Consolidation</span>
    </a>
  </li>
  <li class="nav-item">
    <!-- <a class="nav-link collapsed" href="{{route('inbox')}}"> -->
        <a href="{{route('shareholders.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Ownership</span>
    </a>
  </li>
  <li class="nav-item">
    <!-- <a class="nav-link collapsed" href="{{route('inbox')}}"> -->
        <a href="#" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>SRA</span>
    </a>
  </li>
  <li class="nav-item">
    <!-- <a class="nav-link collapsed" href="{{route('inbox')}}"> -->
        <a href="{{route('faq.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>FAQ</span>
    </a>
  </li>
  <!-- <li class="nav-item">
        <a href="{{route('messages.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Message</span>
    </a>
  </li> -->
  <!-- End Profile Page Nav -->

</ul>

</aside>