<x-app-layout>
    <div id="reader" width="300px" class="mt-10"></div>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
            // QR isi nya dashboard/asets/00001A0001
            
            let url = `${decodedText}`;
            let aset = "{{  URL::asset("") }}";
            let page = aset+url;
            location.replace(page);
        
        //location.replace(`${decodedText}`, decodedResult);   
        //console.log(`Code matched = ${decodedText}`, decodedResult);
        }

        function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout>