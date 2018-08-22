@if (session('message.success'))
<div id="notification" class="alert alert-success">
    <i class="fa fa-check"> </i>
    {{ session('message.success') }}
</div>

<script>
    $(document).ready(() => {
        $('#notification').fadeOut(2500);
    });
</script>
@endif