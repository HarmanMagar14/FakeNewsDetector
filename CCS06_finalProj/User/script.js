function loadArticles(search = '', status = '') {
    $.get("article_fetch.php", { search, status }, function (data) {
        $("#articleTable").html(data);
    });
}

$(document).ready(function() {
    loadArticles();

    $('#searchInput').on('input', function() {
        loadArticles($('#searchInput').val(), $('#statusFilter').val());
    });
    $('#statusFilter').on('change', function() {
        loadArticles($('#searchInput').val(), $('#statusFilter').val());
    });
});
$(document).on("click", ".editBtn", function () {
    const id = $(this).data("id");
    const title = $(this).data("title");
    const content = $(this).data("content");
    const category = $(this).data("category");
    const source_url = $(this).data("source_url");
    const date_published = $(this).data("date_published");
    const status = $(this).data("status");

    // Redirect to article_submit.php with query parameters
    window.location.href = `article_submit.php?id=${id}&title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}&category=${encodeURIComponent(category)}&source_url=${encodeURIComponent(source_url)}&date_published=${date_published}&status=${status}`;
});

// Add or Update Article
$("#articleForm").submit(function (e) {
    e.preventDefault();
    $.post("article_save.php", $(this).serialize(), function (response) {
        alert(response);
        $("#articleForm")[0].reset();
        $("#article_id").val("");
        loadArticles();
    });
});

// Delete Article
$(document).on("click", ".deleteBtn", function () {
    if (confirm("Are you sure you want to delete this article?")) {
        $.post("article_delete.php", { id: $(this).data("id") }, function (response) {
            alert(response);
            loadArticles();
        });
    }

});

