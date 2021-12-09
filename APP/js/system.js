ignoreCache:true;

// JS DARI SINI
console.log("updates 232");

// base url
var base_url = "http://192.168.100.112/piknikgeh/SERVER/API/";

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
$(document).on('page:init', '.page[data-name="detail_wisata"]', function (e, page) {
    var id_wisata = page.route.params.id;
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

// PAGE PERKATEGORI
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

// PAGE CHECKOUT
$(document).on('page:init', '.page[data-name="checkout"]', function (e, page) {
    var wisata_id = page.route.params.uu;
    var jumlah_tiket = page.route.params.ee;
    var username = localStorage.getItem("username");
    app.request({
        url: base_url + "checkout.php",
        type: "POST",
        data: {
            "wisata_id": wisata_id,
            "jumlah_tiket": jumlah_tiket,
            "username": username
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#wisata_nama").html(data.nama_wisata);
                var wisata_harganya = formatNumber(data.harga_wisata);
                $("#wisata_harga").html("Rp " + wisata_harganya);
                $("#wisata_jmlh").html(data.tiketnya_brapa);
                var total_harganya = formatNumber(data.total_harga);
                $("#wisata_total").html("<b>Rp " + total_harganya + "</b>");

                $("#pengguna_nama").val(data.nama_pemesan);
                $("#pengguna_email").val(data.email_pemesan);
                $("#pembayaran").html(data.pembayaran_via);
            }
        }
    });

    $("#pembayaran").change(function() {
        var pembayaran_id = $("#pembayaran").val();
        app.request({
            url: base_url + "pembayaran_note.php",
            type: "POST",
            data: {
                "pembayaran_id": pembayaran_id
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.error) {
                    app.dialog.alert(data.pesan,"Gagal!");
                } else {
                    $("#info_pembayaran").html(data.catatan_metode_pembayaran);
                }
            }
        });
    });

    $$("#pesan").click(function () {
        var nama_pemesan = $$("#pengguna_nama").val();
        var pengguna_email = $$("#pengguna_email").val();
        var pengguna_notelp = $$("#pengguna_notelp").val();
        var pembayaran = $$("#pembayaran").val();

        if(pembayaran == 0){
            app.dialog.alert("Pilih salah satu metode pembayaran","Gagal");
        } else if (nama_pemesan === "" || pengguna_email === "" || pengguna_notelp === ""){
            app.dialog.alert("Pastikan semua terisi","Gagal");
        } else {
            console.log("POST DETEKSI 2");
            app.request({
                url: base_url + "checkout2.php",
                type: "POST",
                data: {
                    "wisata_id": wisata_id,
                    "jumlah_tiket": jumlah_tiket,
                    "username": username,
                    "nama_pemesan": nama_pemesan,
                    "pengguna_email": pengguna_email,
                    "pengguna_notelp": pengguna_notelp,
                    "pembayaran": pembayaran
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.error) {
                        app.dialog.alert(data.pesan,"Gagal!");
                    } else {
                        app.dialog.alert(data.pesan,"Berhasil");
                        if(pembayaran != 1){
                            var link_pembayaran = data.link_pembayaran;
                            location.replace(link_pembayaran);
                        } else {
                            app.views.main.router.navigate('/shopping-cart/');
                        }
                    }
                }
            });
        }
      });


});

// PAGE riwayat pemesanan
$(document).on('page:init', '.page[data-name="list_tiket"]', function (e) {
    var username = localStorage.getItem("username");
    app.request({
        url: base_url + "list_tiket.php",
        type: "POST",
        data: {
            "username": username
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#list_wisatanya").html(data.list_pemesanan);
            }
        }
    });
});


// PAGE riwayat pemesanan
$(document).on('page:init', '.page[data-name="tiket"]', function (e, page) {
    var tiket_id = page.route.params.it;
    app.request({
        url: base_url + "detail_tiket.php",
        type: "POST",
        data: {
            "tiket_id": tiket_id
        },
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error) {
                // app.dialog.alert(data.pesan,"Error.",function () {
                //     app.views.main.router.navigate('/home/');
                //   });
            } else {
                $("#img_tiket").html(data.img_tiket);
                $("#nama_wisata").html(data.nama_wisata);
                $("#detail_tiket").html(data.detail_tiket);
                $("#code_tiket").html(data.code_tiket);
                $("#nama_pemembeli").html(data.nama_pemembeli);
                $("#jumlah_tiket").html(data.jumlah_tiket);
                $("#harga_total").html(data.harga_total);
                $("#pembayaran_tiket").html(data.pembayaran_tiket);
                $("#qr_tiket").html(data.qr_tiket);
            }
        }
    });
});

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
}

function get_total(quantity) {
    var id_wisataa = $$("#id_wisata").val();
    var rate = $("#rate").val();
    var result = eval(quantity) * rate;
    var bilangan = result.toFixed(0);
    var ribu = formatNumber(bilangan);
    $('#buttonr').html("<a href='/shipping-address/" + id_wisataa + "/" + quantity + "/' class='button-large button add-cart-btn button-fill'>Pesan Tiket \
    <span class='price' id='total_price'>Rp " + ribu + "</span>\
</a>");

}


