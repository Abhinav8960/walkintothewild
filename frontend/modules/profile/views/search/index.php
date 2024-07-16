<h3>Search USer</h3>
<div class="container">

    <div class="row">
        <?php foreach ($user_list as $user) { ?>
            <div class="col-md-3">
                <section class="mx-auto my-5" style="max-width: 23rem;">
                    <div class="card testimonial-card mt-2 mb-3">
                        <div class="card-up aqua-gradient"></div>
                        <div class="avatar mx-auto white">
                            <img src="<?= $user->avatar ?>" class="rounded-circle img-fluid" alt="woman avatar">
                        </div>
                        <div class="card-body text-center">
                            <h4 class="card-title font-weight-bold"><?= $user->name ?></h4>
                            <h6 class="card-title"><?= $user->userhandle ?></h4>
                                <hr>
                        </div>
                    </div>
                </section>
            </div>
        <?php } ?>
    </div>

</div>

<style>
    .testimonial-card .card-up {
        height: 120px;
        overflow: hidden;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .aqua-gradient {
        background: linear-gradient(40deg, #2096ff, #05ffa3) !important;
    }

    .testimonial-card .avatar {
        width: 120px;
        margin-top: -60px;
        overflow: hidden;
        border: 5px solid #fff;
        border-radius: 50%;
    }
</style>