DROP DATABASE IF EXISTS dbDaftar;
CREATE DATABASE dbDaftar;
USE dbDaftar;

CREATE TABLE tblPendaftar
(
  nodaftar INT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  alamat VARCHAR(255) NOT NULL,
  noHp VARCHAR(12) NOT NULL
);

/*INSERT INTO tblPendaftar VALUES
(1, "Adi", "Semarang", "08123456789"),
(2, "Budi", "Semarang", "08123257654"),
(3, "Cecep", "Semarang", "09813476174"),
(4, "Dodit", "Semarang", "01937526357"),
(5, "Endra", "Semarang", "09137576782");
*/

SELECT * FROM tblPendaftar;

CREATE TABLE tblPilihan
(
  kode INT PRIMARY KEY,
  pilihan VARCHAR(100) NOT NULL
);

INSERT INTO tblPilihan VALUES
(1, "TEKNIK INFORMATIKA"),
(2, "ELEKTRO"),
(3, "SIPIL"),
(4, "ARSITEKTUK");

CREATE TABLE tblSoal
(
  noSoal INT PRIMARY KEY,
  soal VARCHAR(100) NOT NULL,
  kunciJawaban VARCHAR(1) NOT NULL
);

INSERT INTO tblSoal VALUES
(1, "SOAL 1", "A"),
(2, "SOAL 2", "B"),
(3, "SOAL 3", "A"),
(4, "SOAL 4", "C"),
(5, "SOAL 5", "D"),
(6, "SOAL 6", "E"),
(7, "SOAL 7", "B"),
(8, "SOAL 8", "A"),
(9, "SOAL 9", "B"),
(10, "SOAL 10", "C");

SELECT * FROM tblSoal;

CREATE TABLE tblDaftarSoal
(
  nodaftar INT,
  noSoal INT,
  jawaban VARCHAR(1),
  FOREIGN KEY(nodaftar) REFERENCES tblPendaftar(nodaftar),
  FOREIGN KEY(noSoal) REFERENCES tblSoal(noSoal)
);

SELECT * FROM tblDaftarSoal;

INSERT INTO tblDaftarSoal
SELECT tblPendaftar.nodaftar,
tblSoal.noSoal,
'A'
FROM tblPendaftar, tblSoal;

CREATE TABLE tblDaftarPilihan
(
    nodaftar INT,
    kode INT,
    FOREIGN KEY(nodaftar) REFERENCES tblPendaftar(nodaftar),
    FOREIGN KEY(kode) REFERENCES tblPilihan(kode)
);
/*
INSERT INTO tblDaftarPilihan VALUES
(1,1),
(1,3),
(2,2),
(2,4),
(3,4),
(4,1),
(4,4),
(5,2),
(5,4);
*/



/*Trigger
database server sifatnya pasif, menunggu perintah baru jalan atau dengan kata lain hanya bekerja kalau ada aksi/perintah SQL.
Kita bisa mengubah server database menjadi aktif, menggunakan TRIGGER
TRIGGER kumpulan coding prosedural, harus disimpan dalam katalog database lalu bisa diaktifkan oleh database server saat ada operasi data tertentu (Insert, Update, Delete)

Beda dengan SP, SP harus dipanggil pakai CALL atau EXECUTE. murni jalan sendiri

CREATE TRIGGER {nama trigger}
BEFORE | AFTER
INSERT | UPDATE | DELETE
ON {nama table}

nilai lama dan nilai baru untuk operasi data
NEW.{kolom} | OLD.{kolom}
*/

CREATE TABLE tblHasil
(
  nodaftar INT,
  jumbenar INT,
  jumsalah INT,
  FOREIGN KEY(nodaftar) REFERENCES tblPendaftar(nodaftar)
);

DELIMITER $$
CREATE TRIGGER insert_pendaftar
AFTER INSERT ON tblPendaftar FOR EACH ROW
BEGIN
  INSERT INTO tblDaftarSoal
  SELECT NEW.nodaftar,
  tblSoal.noSoal, ''
  FROM tblSoal;

  INSERT INTO tblHasil VALUES
  (NEW.noDaftar, 0, 0);
END $$
DELIMITER ;

INSERT INTO tblPendaftar VALUES
(1, 'Andi', 'Semarang', '0982147661'),
(2, 'Benny', 'Semarang', '0193748139');

/*CEK TRIGGER, harusnya ada 10 soal*/
SELECT * FROM tblDaftarSoal;

DELIMITER $$
CREATE TRIGGER delete_pendaftar
BEFORE DELETE ON tblPendaftar FOR EACH ROW
BEGIN
  DELETE FROM tblDaftarPilihan
  WHERE nodaftar = OLD.nodaftar;

  DELETE FROM tblHasil
  WHERE noDaftar = OLD.nodaftar;

  DELETE FROM tblDaftarSoal
  WHERE nodaftar = OLD.nodaftar;
END $$
DELIMITER ;

DELETE FROM tblPendaftar WHERE nodaftar = 1;
SELECT * FROM tblDaftarSoal;

/*memasukan jawaban, muncul di tabel baru untuk benar salahnya
berdasarkan update di daftar soal
*/
/*CREATE TABLE HASIL*/

SELECT * FROM tblHasil;

DELIMITER $$
CREATE PROCEDURE spUpdateHasil(pNoDaftar INT, pMana VARCHAR(10))
BEGIN
  IF pMana = 'jumbenar' THEN
    UPDATE tblHasil
    SET jumbenar = jumbenar + 1
    WHERE nodaftar = pNoDaftar;
  ELSE
    UPDATE tblHasil
    SET jumsalah = jumsalah + 1
    WHERE nodaftar = pNoDaftar;
  END IF;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER benarsalah_pendaftar
AFTER UPDATE ON tblDaftarSoal FOR EACH ROW
BEGIN
  DECLARE vKunci VARCHAR(1);

  SELECT kunciJawaban
  INTO vKunci
  FROM tblSoal
  WHERE noSoal = NEW.noSoal;

  IF NEW.jawaban = vKunci THEN
    CALL spUpdateHasil(NEW.nodaftar, 'jumbenar');
  ELSE
    CALL spUpdateHasil(NEW.nodaftar, 'jumsalah');
  END IF;

END $$
DELIMITER ;

/* TRIGGER PANJANG

DELIMITER $$
CREATE TRIGGER benarsalah_pendaftar
AFTER UPDATE ON tblDaftarSoal FOR EACH ROW
BEGIN
  DECLARE vKunci VARCHAR(1);

  SELECT kunciJawaban
  INTO vKunci
  FROM tblSoal
  WHERE noSoal = NEW.noSoal;

  IF NEW.jawaban = vKunci THEN
    UPDATE tblHasil
    SET jumbenar = jumbenar + 1
    WHERE nodaftar = NEW.nodaftar;
  ELSE
    UPDATE tblHasil
    SET jumsalah = jumsalah + 1
    WHERE nodaftar = NEW.nodaftar;
  END IF;

END $$
DELIMITER ;
*/

UPDATE tblDaftarSoal
SET jawaban = 'A'
WHERE nodaftar = 2 AND noSoal =1;

UPDATE tblDaftarSoal
SET jawaban = 'B'
WHERE nodaftar = 2 AND noSoal =2;

UPDATE tblDaftarSoal
SET jawaban = 'C'
WHERE nodaftar = 2 AND noSoal =3;

SELECT * FROM tblHasil;
