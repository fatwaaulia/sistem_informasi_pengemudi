<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" id="cardMenu">
                    <button class="btn me-2" onclick="button_menu('edit')">
                        Edit
                    </button>
                    <button class="btn" onclick="button_menu('maintenance')">
                        Maintenance
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="view_menu"></div>
</div>
</section>

<?php $menu_value = $_GET['menu'] ?? 'edit'; ?>

<script>
window.onload = button_menu('<?= $menu_value ?>'); 
function button_menu(name) {
    window.history.pushState(null, '', `<?= $base_route . '?menu=' ?>${name}`);
    let menu_value = new URL(window.location.href).searchParams.get("menu");

    const menu_buttons = document.querySelectorAll('#cardMenu button');
    menu_buttons.forEach(btn => {
        let btn_value = btn.textContent.trim().toLowerCase();
        if (btn_value == menu_value) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add( 'btn-primary');
        } else {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        }
    });

    fetch(`<?= $base_route . '/menu?v=' ?>${name}`)
    .then(response => response.json())
    .then(data => {
        const view_menu = document.getElementById('view_menu');
        view_menu.innerHTML = data.view_menu;
    });
}
</script>
