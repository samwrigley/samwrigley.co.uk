@if($enabled)
    <div id="{{ $nameFieldName }}_wrap" class="hidden">
        <input name="{{ $nameFieldName }}" type="text" value="" id="{{ $nameFieldName }}">
        <input name="{{ $validFromFieldName }}" type="text" value="{{ $encryptedValidFrom }}">
    </div>
@endif
