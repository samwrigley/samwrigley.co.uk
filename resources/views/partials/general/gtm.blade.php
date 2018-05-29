@if (env('GOOGLE_TAG_MANAGER_ID'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ env('GOOGLE_TAG_MANAGER_ID') }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif