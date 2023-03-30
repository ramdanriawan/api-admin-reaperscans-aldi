<div class="col-12 col-lg-6 col-xl-3">
    <div class="card gradient-deepblue">
        <div class="card-body">
            <h5 class="text-white mb-0">{{ $users->count() }} <span class="float-right"><i
                        class="fa fa-shopping-cart"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
                <div class="progress-bar" style="width:55%"></div>
            </div>
            <p class="mb-0 text-white small-font">Total user<span class="float-right">+{{ $users->count() }} <i
                        class="zmdi zmdi-long-arrow-up"></i></span></p>
        </div>
    </div>
</div>
            