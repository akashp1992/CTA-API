<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div class="text-dark order-2 order-md-1">
            <span class="mr-2">Powered By</span>
            <a href="https://www.cta.com/" target="_blank">
                <img src="{{ asset('images/cta_logo.png') }}" alt="" width="80px">
            </a>
        </div>
        <div class="nav nav-dark">
            <a href="{{ $configuration['website'] }}" target="_blank"
               class="text-dark-75 text-hover-primary">
                <span class="font-weight-bold font-size-h4">{{ $configuration['name'] }}</span>
            </a>
        </div>
    </div>
</div>
