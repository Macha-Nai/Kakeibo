SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+09:00";

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  category varchar(20) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO categories(category) VALUES('食費');
INSERT INTO categories(category) VALUES('日用品');
INSERT INTO categories(category) VALUES('交通費');
INSERT INTO categories(category) VALUES('趣味・娯楽');
INSERT INTO categories(category) VALUES('衣服・美容');
INSERT INTO categories(category) VALUES('教育・教養');
INSERT INTO categories(category) VALUES('その他の支出');
INSERT INTO categories(category) VALUES('給与');
INSERT INTO categories(category) VALUES('仕送り');
INSERT INTO categories(category) VALUES('その他の収入');

DROP TABLE IF EXISTS records;
CREATE TABLE records (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(100) NOT NULL,
  details varchar(100) NOT NULL,
  type int(11) NOT NULL,
  amount int(11) NOT NULL,
  date date NOT NULL,
  created timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  updated timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id)
);