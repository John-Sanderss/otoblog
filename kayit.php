<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $ad = trim($_POST['ad']);
        $soyad = trim($_POST['soyad']);
        $email = trim($_POST['email']);
        $telefon = trim($_POST['tel']);

        if (empty($ad) || empty($soyad) || empty($email) || empty($telefon)) {
            throw new Exception("Tüm alanlar doldurulmalıdır.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Geçerli bir e-posta adresi giriniz.");
        }

        $sql = "INSERT INTO kullanicilar (ad, soyad, email, telefon) VALUES (:ad, :soyad, :email, :telefon)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ad', $ad);
        $stmt->bindParam(':soyad', $soyad);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefon', $telefon);

        $stmt->execute();

        echo "<script>
                alert('Kayıt başarıyla tamamlandı!');
                window.location.href = 'index.html';
              </script>";

    } catch (PDOException $e) {
        echo "<script>
                alert('Veritabanı hatası: " . $e->getMessage() . "');
                window.history.back();
              </script>";
    } catch (Exception $e) {
        echo "<script>
                alert('" . $e->getMessage() . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
