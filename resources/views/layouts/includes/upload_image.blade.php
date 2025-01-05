@push('scripts')
    <script>
        let loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profile-img');
                if (event.target.files[0].type.match('image.*')) {
                    output.src = reader.result;
                } else {
                    event.target.value = '';
                    alert('please select a valid image');
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        };

        let ProfileChange = document.querySelector('#profile-change');
        ProfileChange.addEventListener('change', loadFile);
    </script>
@endpush
