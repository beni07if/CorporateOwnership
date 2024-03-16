<div class="row" style="box-shadow: rgba(44, 73, 100, 0.08) 0px 2px 15px 0px;">
    <div class="col-xl-8 col-lg-6 es d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
        <div class="container" style="padding-top:50px;">
            <h3 class="text-muted">Search other Subsidiaries</h3>
            <!-- <p class="fst-italic">A group company is a collection of individual companies or subsidiaries that are controlled by a single parent company. The parent company, often referred to as the holding company or the group, typically holds a majority stake or controlling the subsidiary companies. The information about Group Company can be used to identify the subsidiary under.</p> -->
            <form action="{{ route('searchFunctionSubsidiary') }}" method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="query" placeholder="Search...">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 es d-flex flex-column align-items-stretch py-5 px-lg-5" style="background-color: #F5F5F5;">
        <div class="blog sidebar">

            <h3>Company Profile Access</h3>
        </div><!-- End sidebar -->
        <!-- <a href="#appointment" class="appointment-btn" style="justify-content: center; align-items:center; text-align:center;">Buy</a> -->
        <div class="line"></div>
        <div class="report-benefit">
            <p>If the data You're looking for is not found, You can contact us via email at helpdesk@earthqualizer.org.</p>
            <p>We will process your request within 3x24 hours.</p>
            <div class="line"></div>
        </div>
    </div>
</div>