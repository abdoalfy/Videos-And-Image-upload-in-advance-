<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #myBar {
            width: 0;
            height: 30px;
            background-color: #04AA6D;
            text-align: center;
            line-height: 30px;
            color: white;
        }
        .drag-drop-area {
            border: 2px dashed #04AA6D;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }
        .drag-drop-area.dragover {
            background-color: #f0f0f0;
        }
        .image-preview {
            width: 100px;
            height: 100px;
            border: 2px solid #ddd;
            margin-top: 10px;
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="image">Image</label>
                <div id="imageDragDrop" class="drag-drop-area">
                    Drag & Drop Image or Click to Upload
                </div>
                <input type="file" name="image" class="form-control d-none" id="image">
                <div class="image-preview" id="imagePreview">
                    <!-- Image preview will be shown here -->
                </div>
            </div>
            <div class="form-group">
                <label for="video">Video</label>
                <div id="videoDragDrop" class="drag-drop-area">
                    Drag & Drop Video or Click to Upload
                </div>
                <input type="file" name="video" class="form-control d-none" id="video">
                <div id="myProgress">
                    <div id="myBar">0%</div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Video</th>
                    <th scope="col">Image</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach ($courses as $brand)
                    <tr>
                        <td scope="row">{{ $i++ }}</td>
                        <td>
                            <video width="200" controls>
                                <source src="{{ asset($brand->video) }}" type="video/{{ pathinfo($brand->video, PATHINFO_EXTENSION) }}">
                                Your browser does not support the video tag.
                            </video>
                        </td>
                        <td><img src="{{ asset($brand->image) }}" height="50"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image Drag & Drop
            var imageDragDrop = document.getElementById('imageDragDrop');
            var imageInput = document.getElementById('image');
            var imagePreview = document.getElementById('imagePreview');

            imageDragDrop.addEventListener('click', function() {
                imageInput.click();
            });

            imageDragDrop.addEventListener('dragover', function(event) {
                event.preventDefault();
                imageDragDrop.classList.add('dragover');
            });

            imageDragDrop.addEventListener('dragleave', function() {
                imageDragDrop.classList.remove('dragover');
            });

            imageDragDrop.addEventListener('drop', function(event) {
                event.preventDefault();
                imageDragDrop.classList.remove('dragover');
                imageInput.files = event.dataTransfer.files;
                displayImagePreview(imageInput.files[0]);
            });

            imageInput.addEventListener('change', function(event) {
                displayImagePreview(event.target.files[0]);
            });

            function displayImagePreview(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
                };
                reader.readAsDataURL(file);
            }

            // Video Drag & Drop
            var videoDragDrop = document.getElementById('videoDragDrop');
            var videoInput = document.getElementById('video');
            var myBar = document.getElementById("myBar");

            videoDragDrop.addEventListener('click', function() {
                videoInput.click();
            });

            videoDragDrop.addEventListener('dragover', function(event) {
                event.preventDefault();
                videoDragDrop.classList.add('dragover');
            });

            videoDragDrop.addEventListener('dragleave', function() {
                videoDragDrop.classList.remove('dragover');
            });

            videoDragDrop.addEventListener('drop', function(event) {
                event.preventDefault();
                videoDragDrop.classList.remove('dragover');
                videoInput.files = event.dataTransfer.files;
                moveProgressBar();
            });

            videoInput.addEventListener('change', function() {
                moveProgressBar();
            });

            function moveProgressBar() {
                var width = 0;
                var id = setInterval(frame, 10);
                function frame() {
                    if (width >= 100) {
                        clearInterval(id);
                    } else {
                        width++;
                        myBar.style.width = width + "%";
                        myBar.innerHTML = width + "%";
                    }
                }
            }
        });
    </script>
</body>
</html>
