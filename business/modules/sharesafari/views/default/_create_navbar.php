<ul class="mynav nav-tabs flex-row">
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>">Overview</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>" onclick="showAlert(event)">Itinerary</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>" onclick="showAlert(event)">Inclusions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link <?= isset($getting_there_active) ? $getting_there_active : '' ?>" onclick="showAlert(event)">Getting There</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>" onclick="showAlert(event)">Policy Info</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="#" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>" onclick="showAlert(event)">FAQ</a>
    </li>
</ul>

<script>
    function showAlert(event) {
        event.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Please fill Overview!!!',
        });
    }
</script>