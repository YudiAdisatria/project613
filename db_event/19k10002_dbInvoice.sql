DROP DATABASE IF EXISTS dbInvoice;
CREATE DATABASE dbInvoice;
USE dbInvoice;

CREATE TABLE tblPelanggan
(
  kodepelanggan VARCHAR(6) PRIMARY KEY DEFAULT "1",
  namapelanggan VARCHAR(100),
  alamat VARCHAR(255)
);

CREATE TABLE tblBarang
(
  kodebarang VARCHAR(1) PRIMARY KEY,
  namabarang VARCHAR(10),
  satuan VARCHAR(10),
  hargastandar DOUBLE
);

CREATE TABLE tblInvoice
(
  noinvoice VARCHAR(20) PRIMARY KEY,
  tanggal DATE,
  kodepelanggan VARCHAR(6),
  FOREIGN KEY(kodepelanggan) REFERENCES tblPelanggan(kodepelanggan)
);

CREATE TABLE tblRinciInvoice
(
  noinvoice VARCHAR(20),
  kodebarang VARCHAR(1),
  panjang INT,
  lebar INT,
  tinggi INT,
  jumlah INT,
  harga DOUBLE,
  FOREIGN KEY(noinvoice) REFERENCES tblInvoice(noinvoice),
  FOREIGN KEY(kodebarang) REFERENCES tblBarang(kodebarang)
);

INSERT INTO tblBarang VALUES
("A", "BARANG A", "LUAS", 10000),
("B", "BARANG B", "LUAS", 12000),
("C", "BARANG C", "KELILING", 7000),
("D", "BARANG D", "LUAS", 15000),
("E", "BARANG E", "LUAS", 18000),
("F", "BARANG F", "KELILING", 22000),
("G", "BARANG G", "LUAS", 8000),
("H", "BARANG H", "VOLUME", 9000),
("I", "BARANG I", "LUAS", 17000),
("J", "BARANG J", "VOLUME", 12000);


/*SOAL 1*/
DELIMITER $$
CREATE TRIGGER tg_kodePelanggan
BEFORE INSERT ON tblPelanggan FOR EACH ROW
BEGIN
  DECLARE tempKode VARCHAR(6);
  DECLARE tempCount INT DEFAULT 0;

  SET tempKode := CONCAT(LEFT(NEW.namapelanggan,1), "-");
  SELECT COUNT(namapelanggan) INTO tempCount FROM tblPelanggan WHERE LEFT(NEW.namapelanggan,1) = LEFT(namapelanggan,1);

  SET tempKode := CONCAT(tempKode, tempCount+1);
  SET NEW.kodepelanggan = tempKode;
END $$
DELIMITER ;

SELECT * FROM tblPelanggan;
INSERT INTO tblPelanggan VALUES(NULL, 'Marlon', 'Semarang');
INSERT INTO tblPelanggan VALUES(NULL, 'Maria', 'Semarang');
INSERT INTO tblPelanggan VALUES(NULL, 'Melly', 'Semarang');
INSERT INTO tblPelanggan VALUES(NULL, 'Anton', 'Semarang');
INSERT INTO tblPelanggan VALUES(NULL, 'Angel', 'Semarang');
SELECT * FROM tblPelanggan;

/*SOAL 2*/
DELIMITER $$
CREATE FUNCTION sfRomawi(pBulan INT)
  RETURNS VARCHAR(5)
BEGIN
  DECLARE vRomawi VARCHAR(5);

  CASE
    WHEN pBulan = 1 THEN SET vRomawi = "I";
    WHEN pBulan = 2 THEN SET vRomawi = "II";
    WHEN pBulan = 3 THEN SET vRomawi = "III";
    WHEN pBulan = 4 THEN SET vRomawi = "IV";
    WHEN pBulan = 5 THEN SET vRomawi = "V";
    WHEN pBulan = 6 THEN SET vRomawi = "VI";
    WHEN pBulan = 7 THEN SET vRomawi = "VII";
    WHEN pBulan = 8 THEN SET vRomawi = "VIII";
    WHEN pBulan = 9 THEN SET vRomawi = "IX";
    WHEN pBulan = 10 THEN SET vRomawi = "X";
    WHEN pBulan = 11 THEN SET vRomawi = "XI";
    ELSE SET vRomawi = "XII";
  END CASE;

    RETURN vRomawi;
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER tg_noInvoice
BEFORE INSERT ON tblInvoice FOR EACH ROW
BEGIN
  DECLARE vCountSurat INT;
  DECLARE vRomawi VARCHAR(5);

  SELECT sfRomawi(MONTH(NEW.tanggal)) INTO vRomawi;
  SELECT COUNT(tanggal) FROM tblInvoice WHERE EXTRACT(YEAR_MONTH FROM tanggal) = EXTRACT(YEAR_MONTH FROM NEW.tanggal) INTO vCountSurat;

  SET NEW.noinvoice = CONCAT(vCountSurat+1,"/IKOM/",vRomawi,"/",YEAR(NEW.tanggal));
END $$
DELIMITER ;

SELECT * FROM tblInvoice;
INSERT INTO tblInvoice VALUES(NULL, '2022/03/13', 'M-1');
INSERT INTO tblInvoice VALUES(NULL, '2022/03/16', 'M-2');
INSERT INTO tblInvoice VALUES(NULL, '2022/04/1', 'M-3');
SELECT * FROM tblInvoice;

/*SOAL 3*/
INSERT INTO tblRinciInvoice VALUES
('1/IKOM/III/2022', 'A', 10, 14, 0, 10, 10000),
('1/IKOM/III/2022', 'B', 20, 16, 0, 11, 12000),
('1/IKOM/III/2022', 'C', 30, 18, 0, 14, 7000),
('1/IKOM/IV/2022', 'D', 15, 20, 0, 15, 15000),
('1/IKOM/IV/2022', 'E', 25, 22, 0, 11, 18000),
('1/IKOM/IV/2022', 'F', 35, 24, 0, 13, 22000),
('2/IKOM/III/2022', 'G', 17, 27, 0, 12, 8000),
('2/IKOM/III/2022','H', 23, 13, 25, 17, 9000),
('2/IKOM/III/2022', 'I', 28, 10, 0, 15, 17000),
('2/IKOM/III/2022', 'J', 21, 28, 31, 17, 21000);

SELECT * FROM tblRinciInvoice;

DELIMITER $$
CREATE FUNCTION sfHitungan(pSatuan VARCHAR(10), vPanjang INT, vLebar INT, vTinggi INT)
  RETURNS INT
BEGIN
  DECLARE vHitungan INT;

  IF pSatuan = "LUAS" THEN
    SET vHitungan = vPanjang * vLebar;
  ELSEIF pSatuan = "KELILING" THEN
    SET vHitungan = 2*(vPanjang + vLebar);
  ELSE
    SET vHitungan = vPanjang * vLebar * vTinggi;
  END IF;

  RETURN vHitungan;
END $$
DELIMITER ;

DELIMITER $$
CREATE FUNCTION sfKeterangan(vKode VARCHAR(10), pSatuan VARCHAR(10), vPanjang INT, vLebar INT, vTinggi INT)
  RETURNS VARCHAR(100)
BEGIN
  DECLARE vKeterangan VARCHAR(100);

  IF pSatuan = "LUAS" THEN
    SET vKeterangan = CONCAT("BARANG ", vKode,": ", vPanjang, "x", vLebar);
  ELSEIF pSatuan = "KELILING" THEN
    SET vKeterangan = CONCAT("BARANG ", vKode,": ", "2x(",vPanjang, "+", vLebar, ")");
  ELSE
    SET vKeterangan = CONCAT("BARANG ", vKode,": ", vPanjang, "x", vLebar, "x", vLebar);
  END IF;

  RETURN vKeterangan;
END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE spBacaRincian()
BEGIN
  DECLARE vNoInvoice VARCHAR(20);
  DECLARE vKode VARCHAR(10);
  DECLARE vPanjang INT;
  DECLARE vLebar INT;
  DECLARE vTinggi INT;
  DECLARE vJumlah INT;
  DECLARE vSatuan VARCHAR(10);
  DECLARE vHarga INT;
  DECLARE vHitung INT;
  DECLARE vJumData INT;
  DECLARE i INT DEFAULT 1;

  DECLARE cDimensi CURSOR FOR
    SELECT *
    FROM tblRinciInvoice;

  SELECT COUNT(*) INTO vJumData FROM tblBarang;

  OPEN cDimensi;
    loopbaca: WHILE i <= vJumData DO
      FETCH cDimensi INTO vNoInvoice, vKode, vPanjang, vLebar, vTinggi, vJumlah, vHarga;

      SELECT tblBarang.satuan FROM tblBarang INNER JOIN tblRinciInvoice ON (tblBarang.kodebarang = tblRinciInvoice.kodebarang) WHERE tblBarang.kodebarang = vKode INTO vSatuan;

      SELECT sfHitungan(vSatuan, vPanjang, vLebar, vTinggi) INTO vHitung;

      SELECT vNoInvoice AS NO_INVOICE, sfKeterangan(vKode, vSatuan, vPanjang, vLebar, vTinggi) AS KETERANGAN_BARANG, vHitung AS HITUNGAN, vJumlah AS JUMLAH, vHarga AS HARGA, vHitung*vJumlah*vHarga AS SUBTOTAL;

      SET i = i+1;
    END WHILE loopbaca;
  CLOSE cDimensi;

END $$
DELIMITER ;

CALL spBacaRincian();

/*SOAL 4*/
DELIMITER $$
CREATE PROCEDURE spResume()
BEGIN
  DECLARE vtanggal INT;
  DECLARE vJumData INT;
  DECLARE i INT DEFAULT 1;

  DECLARE cTanggal CURSOR FOR
    SELECT tanggal
    FROM tblInvoice;

  SELECT COUNT(*) INTO vJumData FROM tblInvoice;

  OPEN cTanggal;
    loopbaca: WHILE i <= vJumData DO
      FETCH cTanggal INTO vTanggal;

      SELECT DATE_FORMAT(vtanggal, '%m-%Y') AS "BULAN|TAHUN", COUNT(noinvoice) FROM tblInvoice AS JUMLAH_TRANSAKSI WHERE DATE_FORMAT(tanggal, '%m-%Y') = DATE_FORMAT(vtanggal, '%m-%Y');

      SELECT tblInvoice.noinvoice AS NO_INVOICE, tblInvoice.tanggal AS TANGGAL_INVOICE, tblPelanggan.namapelanggan AS PELANGGAN, SUM(sfHitungan(tblBarang.satuan, tblRinciInvoice.panjang, tblRinciInvoice.lebar, tblRinciInvoice.tinggi)*tblRinciInvoice.jumlah*tblRinciInvoice.harga) AS TOTAL_INVOICE
      FROM tblPelanggan INNER JOIN tblInvoice ON(tblPelanggan.kodepelanggan = tblInvoice.kodepelanggan) INNER JOIN tblRinciInvoice ON(tblInvoice.noinvoice = tblRinciInvoice.noinvoice) INNER JOIN tblBarang ON(tblRinciInvoice.kodebarang = tblBarang.kodebarang)
      WHERE DATE_FORMAT(tblInvoice.tanggal, '%m-%Y') = DATE_FORMAT(vtanggal, '%m-%Y')
      GROUP BY tblPelanggan.namapelanggan;

      SET i = i+1;
    END WHILE loopbaca;
  CLOSE cTanggal;
END $$
DELIMITER ;

CALL spResume();
