ignoreCache:true;
// JS DARI SINI
console.log("updates 232");

// base url
var base_url = "http://localhost/SERVER/API/";

// CEK LOGIN
cek();
function cek() {
  var status = localStorage.getItem("status");
  if (status == "login") {
      app.views.main.router.navigate('/home/');
  } else {
    app.views.main.router.navigate('/');
  }
}

// PAGE LOGIN
$(document).on('page:init', '.page[data-name="register"]', function (e) {
    console.log("Page Daftar");
    $$("#daftar").click(function () {
      console.log("POST DETEKSI");
      var first_name = $$("#first_name").val();
      var last_name = $$("#last_name").val();
      var email = $$("#email").val();
      var username = $$("#dusername").val();
      var password = $$("#dpassword").val();
      var passwordd = $$("#passwordd").val();
      app.request({
          url: base_url + "daftar.php",
          type: "POST",
          data: {
              "first_name": first_name,
              "last_name": last_name,
              "email": email,
              "username": username,
              "password": password,
              "passwordd": passwordd
          },
          dataType: 'json',
          success: function (data) {
              console.log(data);
              if (data.error) {
                  app.dialog.alert(data.pesan,"Gagal!");
              } else {
                  $$("#first_name").val("");
                  $$("#last_name").val("");
                  $$("#email").val("");
                  $$("#username").val("");
                  $$("#password").val("");
                  $$("#password2").val("");
                  localStorage.setItem("status", "login");
                  localStorage.setItem("id", data[0].id);
                  localStorage.setItem("username", data[0].username);
                  app.dialog.alert(data.pesan,"Berhasil");
                  app.views.main.router.navigate('/home/');
              }
          }
      });
    });
  });

// PAGE LOGIN
$(document).on('page:init', '.page[data-name="login"]', function (e) {
  console.log("Page Login");
  $$("#masuk").click(function () {
    console.log("POST DETEKSI");
    var username = $$("#username").val();
    var password = $$("#password").val();
    app.request({
        url: base_url + "masuk.php",
        type: "POST",
        data: {
            "username": username,
            "password": password
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                app.dialog.alert(data.pesan,"Login Gagal!");
            } else {
                $$("#username").val("");
                $$("#password").val("");
                localStorage.setItem("status", "login");
                localStorage.setItem("id", data[0].id);
                localStorage.setItem("username", data[0].username);
                app.dialog.alert(data.pesan,"Berhasil");
                app.views.main.router.navigate('/home/');
            }
        }
    });
  });
});

// PAGE HOME
$(document).on('page:init', '.page[data-name="homepage"]', function (e) {
    console.log("Page Home");
    var username = localStorage.getItem("username");
    app.request({
        url: base_url + "beranda.php",
        type: "POST",
        data: {
            "username": username
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                app.dialog.alert(data.pesan,"Error Update.");
            } else {
                $("#salam").html(data.salam);
                $("#nama").html(data.nama);
                $("#banner").html(data.banner);
                $("#categoriess").html(data.categories);
                $("#trending").html(data.trending);
            }
        }
    });
      
});

// PAGE PROFILE
$(document).on('page:init', '.page[data-name="profile"]', function (e) {
    console.log("Page PROFILE");
    var username = localStorage.getItem("username");
    app.request({
        url: base_url + "profile.php",
        type: "POST",
        data: {
            "username": username
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                app.dialog.alert(data.pesan,"Error Update.");
            } else {
                $("#username").html(username);
                $("#nama_profile").html(data.nama);
                $("#email").html(data.email);
            }
        }
    });
    $$("#logout_button").click(function () {
        localStorage.removeItem("status");
        localStorage.removeItem("id");
        localStorage.removeItem("username");
        app.dialog.alert("Berhasil Keluar","Berhasil");
        cek();
    });
    
});

// PAGE ITEM DETAILS
$(document).on('page:init', '.page[data-name="detail_wisata"]', function (e) {
    var id_wisata = $$("#id_wisata").val();
    app.request({
        url: base_url + "detail_wisata.php",
        type: "POST",
        data: {
            "id_wisata": id_wisata
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#detail_nama").html(data.nama);
                $("#nama_kat").html(data.nama_kat);
                var harganya = formatNumber(data.harga_tiket);
                $("#detail_harga").html(harganya);
                $("#detail_deskripsi").html(data.deskripsi);
                $("#pic1").html("<img src='" + data.pic1 + "'>");
                $("#pic2").html("<img src='" + data.pic2 + "'>");
                $("#pic3").html("<img src='" + data.pic3 + "'>");
                $("#pic4").html("<img src='" + data.pic4 + "'>");
                $("#rate").val(data.harga_tiket);
                $("#total_price").html("Rp "+harganya);
            }
        }
    });
});

// PAGE KATEGORI
$(document).on('page:init', '.page[data-name="kategori"]', function (e) {
    var id_wisata = $$("#id_wisata").val();
    app.request({
        url: base_url + "kategori.php",
        type: "POST",
        data: {
            "XX": "-"
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#kategorinya").html(data.kategorii);
            }
        }
    });
});

// PAGE KATEGORI
$(document).on('page:init', '.page[data-name="perkategori"]', function (e) {
    var id_kat = $$("#id_kat").val();
    app.request({
        url: base_url + "perkategori.php",
        type: "POST",
        data: {
            "id_kat": id_kat
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#wizz").html(data.list_wisata);
                $("#jumwizz").html(data.jumwiz);
            }
        }
    });
});


function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
}

function get_total(quantity) {
    var rate = $("#rate").val();
    var result = eval(quantity) * rate;
    var bilangan = result.toFixed(0);
    var ribu = formatNumber(bilangan);
    $('#total_price').html("Rp "+ribu);
}


