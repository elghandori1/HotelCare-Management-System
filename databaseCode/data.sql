http://localhost/vichyProjet/connexionvichy  

=================htaccess================
Options +MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^.]+)$ $1.php [NC,L]
================================
Options +MultiViews
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^.]+)$ $1.php [NC,L]

RewriteEngine On
RewriteRule ^vichyy$ vichy/vichy [NC,L]


============================database_vichy1============================
drop database vichy1;

create database vichy1;


-------------------
CREATE TABLE utilisateurs ( 
id_user INT PRIMARY KEY AUTO_INCREMENT, 
nom_user VARCHAR(256),
login_user VARCHAR(255), 
password_user VARCHAR(255), 
role VARCHAR(255));

INSERT INTO utilisateurs VALUES(DEFAULT,'youssef',"admin",'admin123','AdminPage.php'),
(DEFAULT,'Mohamed',"mohamed",'mohamed123','TechnicienPage.php'),
(DEFAULT,'latifa',"latifa",'latifa123','ReclamePage.php'),
(DEFAULT,'philip',"philip",'philip123','DirecteurPage.php');

-------------------------
CREATE TABLE gestionsTraveaux ( 
idgestionT INT PRIMARY KEY AUTO_INCREMENT,
id_utilisateur int,
Num_chambre varchar(256),
date_reclamation DATE DEFAULT CURRENT_DATE, 
Hour_reclamation time,
date_validation DATE,
Hour_validation time,
status_gestion VARCHAR(256) DEFAULT 'no-valid',
FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_user) ON DELETE CASCADE
);


INSERT INTO gestionsTraveaux  VALUES
(default,3,'200',NOW(),NOW(),'no-valid'),
(default,2,'201',NOW(),NOW(),'valid'),
(default,2,'202',NOW(),NOW(),'valid'),
(default,2,'203',NOW(),NOW(),'en-coure');

-------------------------
CREATE TABLE convrsations (
idConver INT PRIMARY KEY AUTO_INCREMENT,
id_gestion INT,
id_utilisateur INT,
conver_message varchar(256) default Null,
date_conversation date, 
FOREIGN KEY (id_gestion) REFERENCES gestionsTraveaux(idgestionT),
FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_user)
);

INSERT INTO gestionsTraveaux  VALUES
(default,1,3,'robéni',NOW()),
(default,1,3,'tv',NOW()),
(default,2,3,'phone',NOW()),
(default,2,3,'robéni',NOW());


====================================================================================