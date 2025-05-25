let fakeKeywords = [];
$(document).ready(function() {
  // Fetch fake keywords from the server
  $.getJSON('get_fake_keywords.php', function(data) {
    fakeKeywords = data;
  });

  // --- Chart.js Reports ---

  if ($("#fakeTrueChart").length) {
    $.getJSON('admin_report_detection.php', function(data) {
      const labels = Object.keys(data);
      const fakeData = labels.map(date => data[date]['Fake'] || 0);
      const trueData = labels.map(date => data[date]['True'] || 0);

      new Chart(document.getElementById('fakeTrueChart'), {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            { label: 'Fake', data: fakeData, borderColor: 'red', backgroundColor: 'rgba(255,0,0,0.1)', fill: true },
            { label: 'True', data: trueData, borderColor: 'green', backgroundColor: 'rgba(0,255,0,0.1)', fill: true }
          ]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                callback: function(value) { return Number.isInteger(value) ? value : null; }
              }
            }
          }
        }
      });
    });
  }

  if ($("#keywordChart").length) {
    $.getJSON('admin_report_keywords.php', function(data) {
      const labels = Object.keys(data);
      const counts = Object.values(data);

      new Chart(document.getElementById('keywordChart'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Occurrences',
            data: counts,
            backgroundColor: 'orange'
          }]
        },
        options: { responsive: true }
      });
    });
  }

  if ($("#statusChart").length) {
    $.getJSON('admin_report_status.php', function(data) {
      const labels = Object.keys(data);
      const counts = Object.values(data);

      new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: counts,
            backgroundColor: ['#ffc107', '#28a745', '#dc3545']
          }]
        },
        options: { responsive: true }
      });
    });
  }

  loadArticles();

  // Row click: show modal with details and detection
  $(document).on('click', '.article-row', function(e) {
    // Prevent triggering when clicking Approve/Reject buttons
    if ($(e.target).hasClass('approveBtn') || $(e.target).hasClass('rejectBtn')) return;

    let id = $(this).data('id');
    let title = $(this).data('title');
    let content = $(this).data('content');
    let category = $(this).data('category');
    let date = $(this).data('date_published');
    let status = $(this).data('status');

    $("#modal-id").text(id);
    $("#modal-title").text(title);
    $("#modal-content").text(content);
    $("#modal-category").text(category);
    $("#modal-date").text(date);
    $("#modal-status").text(status);

    // Fake news detection using dynamic keywords
    let found = 0;
    let contentLower = content.toLowerCase();
    fakeKeywords.forEach(function(word) {
      if (contentLower.includes(word.toLowerCase())) found++;
    });
    let percent = fakeKeywords.length > 0 ? Math.round((found / fakeKeywords.length) * 100) : 0;
    if (found > 0) {
      $("#detectionResult").html("<span class='text-danger'>FAKE</span>");
      $("#detectionPercent").html(percent + "% fake keywords found");
    } else {
      $("#detectionResult").html("<span class='text-success'>TRUE</span>");
      $("#detectionPercent").html("No fake keywords found");
    }

    // Set approve/reject buttons to this article
    $("#approveBtn").data("id", id);
    $("#rejectBtn").data("id", id);

    var modal = new bootstrap.Modal(document.getElementById('articleModal'));
    modal.show();
  });

  // Approve button in modal
  $("#approveBtn").click(function() {
    var id = $(this).data('id');
    $.post('admin_article_status.php', { id: id, status: 'Approved' }, function(response) {
      loadArticles();
      bootstrap.Modal.getInstance(document.getElementById('articleModal')).hide();
    });
  });

  // Reject button in modal
  $("#rejectBtn").click(function() {
    var id = $(this).data('id');
    $.post('admin_article_status.php', { id: id, status: 'Rejected' }, function(response) {
      loadArticles();
      bootstrap.Modal.getInstance(document.getElementById('articleModal')).hide();
    });
  });

  // Approve/Reject from table (optional, can remove if only want modal)
  $(document).on('click', '.approveBtn', function(e) {
    e.stopPropagation();
    var id = $(this).data('id');
    $.post('admin_article_status.php', { id: id, status: 'Approved' }, function(response) {
      loadArticles();
    });
  });
  $(document).on('click', '.rejectBtn', function(e) {
    e.stopPropagation();
    var id = $(this).data('id');
    $.post('admin_article_status.php', { id: id, status: 'Rejected' }, function(response) {
      loadArticles();
    });
  });
});

// Load Articles
function loadArticles(search = '', status = '') {
  $.get("admin_article_fetch.php", { search, status }, function (data) {
    $("#adminArticleTable").html(data);
  });
}

$(document).ready(function() {
  // Initial load
  loadArticles();

  // Search/filter events
  $('#adminSearchInput').on('input', function() {
    loadArticles($('#adminSearchInput').val(), $('#adminStatusFilter').val());
  });
  $('#adminStatusFilter').on('change', function() {
    loadArticles($('#adminSearchInput').val(), $('#adminStatusFilter').val());
  });
});

function loadUsers() {
  $.get('admin_user_fetch.php', function(data) {
    let users = JSON.parse(data);
    let html = '';
    users.forEach(u => {
      html += `<tr>
        <td>${u.id}</td>
        <td>${u.firstname}</td>
        <td>${u.lastname}</td>
        <td>${u.username}</td>
        <td>${u.email}</td>
        <td>
          <select class="form-select user-role" data-id="${u.id}">
            <option value="user" ${u.usertype === 'user' ? 'selected' : ''}>User</option>
            <option value="admin" ${u.usertype === 'admin' ? 'selected' : ''}>Admin</option>
          </select>
        </td>
        <td>
          <button class="btn btn-sm btn-warning editUserBtn"
            data-id="${u.id}"
            data-firstname="${u.firstname}"
            data-lastname="${u.lastname}"
            data-username="${u.username}"
            data-email="${u.email}"
            data-role="${u.usertype}">
            <i class="bi bi-pencil-square"></i>
          </button>
          <button class="btn btn-sm btn-danger deleteUserBtn" data-id="${u.id}">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>`;
    });
    $('#usersTable').html(html);
  });
}

$(document).ready(function() {
  if ($('#usersTable').length) loadUsers();

  // Add User
  $('#addUserForm').submit(function(e) {
    e.preventDefault();
    $.post('admin_user_create.php', $(this).serialize(), function(response) {
      $('#addUserModal').modal('hide');
      loadUsers();
      $('#addUserForm')[0].reset();
      alert(response);
    }).fail(function(xhr) {
      alert('Error: ' + xhr.responseText);
    });
  });

  // Edit User: fill modal
  $(document).on('click', '.editUserBtn', function() {
    const btn = $(this);
    $('#editUserModal [name="id"]').val(btn.data('id'));
    $('#editUserModal [name="firstname"]').val(btn.data('firstname'));
    $('#editUserModal [name="lastname"]').val(btn.data('lastname'));
    $('#editUserModal [name="username"]').val(btn.data('username'));
    $('#editUserModal [name="email"]').val(btn.data('email'));
    $('#editUserModal [name="role"]').val(btn.data('role'));
    $('#editUserModal').modal('show');
  });

  // Update User
  $('#editUserModal form').submit(function(e) {
    e.preventDefault();
    $.post('admin_user_update.php', $(this).serialize(), function(response) {
      $('#editUserModal').modal('hide');
      loadUsers();
      alert(response);
    }).fail(function(xhr) {
      alert('Error: ' + xhr.responseText);
    });
  });

  // Delete User
  $(document).on('click', '.deleteUserBtn', function() {
    if (!confirm('Delete this user?')) return;
    $.post('admin_user_delete.php', { id: $(this).data('id') }, function(response) {
      loadUsers();
      alert(response);
    }).fail(function(xhr) {
      alert('Error: ' + xhr.responseText);
    });
  });

  // Change Role
  $(document).on('change', '.user-role', function() {
    const id = $(this).data('id');
    const role = $(this).val();
    $.post('admin_user_role.php', { id, role }, function() {
      loadUsers();
    });
  });
});

function loadCategories() {
  $.get('admin_category_fetch.php', function(data) {
    let cats = JSON.parse(data);
    let html = '';
    cats.forEach(c => {
      html += `<tr>
        <td><span class="cat-name" data-id="${c.id}">${c.name}</span></td>
        <td>
          <button class="btn btn-sm btn-warning editCatBtn" data-id="${c.id}" data-name="${c.name}">Edit</button>
          <button class="btn btn-sm btn-danger deleteCatBtn" data-id="${c.id}">Delete</button>
        </td>
      </tr>`;
    });
      $('#categoryTable').html(html);
  });
}

$(document).ready(function() {
  loadCategories();

  $('#addCategoryForm').submit(function(e) {
    e.preventDefault();
    $.post('admin_category_create.php', $(this).serialize(), function(msg) {
      alert(msg);
      loadCategories();
      $('#addCategoryForm')[0].reset();
    });
  });

  $(document).on('click', '.editCatBtn', function() {
    let id = $(this).data('id');
    let name = prompt("Edit category name:", $(this).data('name'));
    if (name) {
      $.post('admin_category_update.php', {id, name}, function(msg) {
        alert(msg);
        loadCategories();
      });
    }
  });

  $(document).on('click', '.deleteCatBtn', function() {
    if (confirm("Delete this category?")) {
      $.post('admin_category_delete.php', {id: $(this).data('id')}, function(msg) {
        alert(msg);
        loadCategories();
      });
    }
  });
});

function loadActivityLogs() {
  $.get('admin_log_fetch.php', function(data) {
    $('#activityLogTable').html(data);
  });
}
$(document).ready(function() {
  loadActivityLogs();
});