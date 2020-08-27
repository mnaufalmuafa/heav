$(document).ready(function() {
  setUpAlert();
  setBtnUbahDataOnClickListener();
  setUpBtnCashout();
  setBtnTambahBukuOnClickListener();
  setTrashIconOnClickListener();
  setRating();
  setBtnEditBukuOnClickListener();
  setBtnViewBukuOnClickListener();
});

function setBtnUbahDataOnClickListener() {
  $('#btnUbahData').click(function() {
		$(location).attr("href", "/publisher/edit");
  });
}

function setBtnTambahBukuOnClickListener() {
  $('#btnTambahBuku').click(function() {
    $(location).attr("href", "/publisher/input/book");
  });
}

function setTrashIconOnClickListener() {
  $('.ic-trash').click(function() {
    var title = $(this).attr("book-title");
    Swal.fire({
      title: "Apakah anda yakin akan menghapus buku \""+title+' ?',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText : 'Tidak'
    }).then((result) => {
      if (result.value) {
        var id = $(this).attr("book-id");
        $.ajax({
          url : "/publisher/delete/book",
          method : "POST",
          data : {
            "id" : id
          }
        }).done(function() {
          storeFlashMessage("Berhasil menghapus buku "+"\""+title+"\"", "success", 2);
          $("#book-card-"+id).remove();
          setUpAlert();
        });
      }
    });
  });
}

function setRating() {
  $('.card-book').each(function() {
    var rating = $(this).attr("rating");
    var id = $(this).attr("id");
    rating = parseFloat(rating);
    rating = rating.toFixed(1);
    $("#"+id + " .book-rating-container p span:first-child").html(rating);
    rating = Math.floor(rating);
    if (rating >= 1) {
      $('#'+id+' .first-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 2) {
      $('#'+id+' .second-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 3) {
      $('#'+id+' .third-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating >= 4) {
      $('#'+id+' .fourth-star').attr("src","/image/icon/yellow_star.png");
    }
    if (rating == 5) {
      $('#'+id+' .fifth-star').attr("src","/image/icon/yellow_star.png");
    }
  });
  
}

function setBtnEditBukuOnClickListener() {
  $('.btn-edit-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/publisher/edit/book?id="+id;
  });
}

function setBtnViewBukuOnClickListener() {
  $('.btn-view-buku').click(function() {
    var id = $(this).attr("book-id");
    window.location.href = "/book/detail/"+id+"/"+string_to_slug($(this).attr("book-title"));
  });
}

function setUpBtnCashout() {
  var balance = $('meta[name=balance]').attr("content");
  balance = parseInt(balance);
  if (balance >= 30000) {
    var kelas = $("#btnCashout").attr("class");
    kelas = kelas.replace("none", "inline");
    $("#btnCashout").attr("class", kelas);
    $("#btnCashout").attr("onclick", "window.location.href = \"/publisher/cashout\"");
  }
}