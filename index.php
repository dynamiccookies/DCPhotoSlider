<?php
$images = glob('pics/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        .photo-viewer {
            position: relative;
            width: 80%;
            max-width: 800px;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }

        .photo-container {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            width: 100%;
            height: 500px; /* Fixed height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .photo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .thumbnails {
            display: flex;
            flex-wrap: wrap; /* Allow thumbnails to wrap */
            justify-content: flex-start; /* Align thumbnails to the left */
            gap: 10px;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
            cursor: pointer;
            border: 1px solid #ccc;
            object-fit: cover;
        }

        .thumbnail:hover {
            border-color: #000;
        }

        .arrow {
            position: absolute;
            top: 50%;
            width: 60px; /* Increased width */
            height: 60px; /* Increased height */
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: center;
            line-height: 60px; /* Match height for centering text */
            font-size: 24px; /* Larger font size */
            cursor: pointer;
            user-select: none;
            transform: translateY(-50%);
        }

        .arrow-left {
            left: 0;
        }

        .arrow-right {
            right: 0;
        }

        .photo-number {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.5); /* White transparent background */
            color: #000; /* Black text */
            text-align: center;
            padding: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="photo-viewer">
        <div class="photo-container">
            <div class="photo-number" id="photo-number">1 / <?php echo count($images); ?></div>
            <img id="current-photo" src="" alt="Photo">
            <div class="arrow arrow-left">&lt;</div>
            <div class="arrow arrow-right">&gt;</div>
        </div>
        <div class="thumbnails" id="thumbnails">
            <!-- Thumbnails will be generated here by JavaScript -->
        </div>
    </div>

    <script>
        const thumbnailsContainer = document.getElementById('thumbnails');
        const currentPhoto = document.getElementById('current-photo');
        const photoNumber = document.getElementById('photo-number');
        let photos = <?php echo json_encode($images); ?>;

        // Function to update the current photo
        function updatePhoto(index) {
            currentPhoto.src = photos[index];
            photoNumber.textContent = `${index + 1} / ${photos.length}`;
        }

        let currentIndex = 0;

        // Event listeners for arrow navigation
        document.querySelector('.arrow-left').addEventListener('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : photos.length - 1;
            updatePhoto(currentIndex);
        });

        document.querySelector('.arrow-right').addEventListener('click', function() {
            currentIndex = (currentIndex < photos.length - 1) ? currentIndex + 1 : 0;
            updatePhoto(currentIndex);
        });

        // Create thumbnails dynamically
        photos.forEach((photoSrc, index) => {
            // Create thumbnail
            const thumbnail = document.createElement('img');
            thumbnail.src = photoSrc;
            thumbnail.classList.add('thumbnail');
            thumbnail.alt = `Thumbnail ${index + 1}`;
            thumbnailsContainer.appendChild(thumbnail);

            // Add click event to update main photo on thumbnail click
            thumbnail.addEventListener('click', () => {
                updatePhoto(index);
            });
        });

        // Initial photo display
        if (photos.length > 0) {
            updatePhoto(0);
        }
    </script>
</body>
</html>
