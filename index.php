<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images Uploader</title>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="col-md-6 wrapper">
        <h2 class="header">Upload your Image</h2>
        <hr>
        <form id="imgForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                          <input accept=".jpg,.png,.gif,.jpeg" type="file" name="fileName" onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])" required class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                      </div>
                      <button class="btn btn-success mb-3">Upload</button>
                    <div class="progress mb-3 d-none">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <div class="copy text-center d-none">
                        <input type="text" class="form-control copyInput mb-2" id="copyInput" placeholder="Copy your image link">
                        <a href="#" target="_blank" class="btn btn-info viewBtn mb-3">View</a>
                        <button type="button" class="btn btn-primary copyBTN mb-3">Copy Link</button>
                        <a href="#" download class="btn btn-success downloadBtn mb-3">Download</a>
                    </div>
                </div>
                <div class="col-md-4 preview">
                    <img src="image/preview.jpg" class="img-fluid preimage" id="preview" alt="preview image">
                </div>
            </div>
        </form>
    </div>
    <script>
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $(".copyBTN").click(function(){
            var copyText = document.getElementById("copyInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            $('.copyBTN').html("Copyied 😎");
            setTimeout(function(){
                $('.copyBTN').html("Copy");
            },2000);
        })

        $('#imgForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $('.progress').removeClass('d-none');
            $.ajax({
                url : 'process.php',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                type: 'POST',
                 xhr: function() {
                 var xhr = new XMLHttpRequest();
                 xhr.upload.addEventListener('progress', function(e) {
                 if (e.lengthComputable) {
                     var uploadpercent = e.loaded / e.total;
                     uploadpercent = (uploadpercent * 100);
                     $('.progress-bar').width(uploadpercent + '%');
                     var textPercentage = Math.floor(uploadpercent);
                     $('.progress-bar').text(textPercentage + '%');
                     if (uploadpercent == 100) {
                         $('.progress-bar').text('Completed');
                         $('.progress-bar').addClass('bg-success');
                         setTimeout(() => {
                        $('.progress-bar').width(0 + '%');
                         }, 2000);
                         setTimeout(() => {
                            $('.progress').addClass('d-none');
                         }, 3000);
                     }
                 }
                 }, false);
                 return xhr;
                 },
                success : function(data) {
                    $('#imgForm')[0].reset();
                    $('.custom-file-label').html('Choose File');
                    // $('.preview').html('<img src="image/preview.jpg" class="img-fluid preimage" id="preview" alt="preview image">');

                    if(data == 1){
                        alert("Error File type or too large !");
                    }else if(data == 2){
                        alert("Something went Wrong !");
                    }else{
                        $(".copy").removeClass('d-none');
                        $('.copyInput').val(data);
                        $('.viewBtn').attr('href',data);
                        $('.downloadBtn').attr('href',data);
                    }
                }
            });
        })





        </script>


</body>
</html>