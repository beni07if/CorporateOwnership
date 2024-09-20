
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{route('dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
  <li class="nav-item">
    <a href="{{route('landing-page.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Landing Page</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('faq.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>FAQ</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('policy.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Public & Policy</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{route('term-of-condition.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Term and Condition</span>
    </a>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Database</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li class="nav-item">
        <a href="{{route('groups.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
          <i class="bi bi-inbox"></i>
          <span>Group</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('consolidations.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
          <i class="bi bi-inbox"></i>
          <span>Consolidation</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('shareholders.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
          <i class="bi bi-inbox"></i>
          <span>Shareholder</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('sras.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
          <i class="bi bi-inbox"></i>
          <span>SRA</span>
        </a>
      </li>
    </ul>
  </li> --}}
  
  {{-- <li class="nav-item nav-link">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onchange="toggleMaintenanceMode(this.checked)">
        <label class="form-check-label" for="flexSwitchCheckDefault">Maintenance Mode</label>
    </div>
  </li> --}}

  <script>
      function toggleMaintenanceMode(isChecked) {
          fetch('/toggle-maintenance', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure CSRF token is included
              },
              body: JSON.stringify({ maintenance: isChecked })
          })
          .then(response => response.json())
          .then(data => {
              if (data.maintenance) {
                  window.location.href = '/maintenance-mode'; // Redirect to maintenance mode page
              } else {
                  window.location.href = '/'; // Redirect to index page
              }
          })
          .catch(error => console.error('Error:', error));
      }
  </script>

  <!-- End Components Nav -->
  <!-- <li class="nav-item">
    <a href="{{route('messages.index')}}" class="nav-link collapsed {{ request()->is('inbox') ? 'active' : '' }}">
      <i class="bi bi-inbox"></i>
      <span>Message</span>
    </a>
  </li> -->
  <!-- End Profile Page Nav -->

</ul>

</aside>
