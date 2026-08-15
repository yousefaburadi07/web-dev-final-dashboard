function deleteImage(imageId, imageUrl) {
    if (!confirm("Are you sure you want to delete this image?")) return;

    fetch('delete_image.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'img_id=' + imageId + '&img_url=' + imageUrl
    })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                document.getElementById('img-box-' + imageId).remove();
            } else {
                alert("Failed to delete image: " + data);
            }
        });
}
