------------------------------------------------------------
--        Script Postgres
------------------------------------------------------------


DROP SCHEMA IF EXISTS Bankroll CASCADE;
CREATE SCHEMA IF NOT EXISTS Bankroll;

------------------------------------------------------------
-- Table: Utilisateur
------------------------------------------------------------
CREATE TABLE Bankroll.Utilisateur(
	idClient SERIAL ,
	Mail 	 VARCHAR (200) NOT NULL UNIQUE ,
	Nom      VARCHAR (32) NOT NULL ,
	Prenom   VARCHAR (32) NOT NULL ,
	CONSTRAINT pk_Utilisateur PRIMARY KEY (idClient)
);

------------------------------------------------------------
-- Table: Password
------------------------------------------------------------
CREATE TABLE Bankroll.Password(
	idClient integer,
	Pass 	 VARCHAR (40) NOT NULL,
	CleRecup VARCHAR (68) NOT NULL default generateKey(),
	CONSTRAINT pk_Password PRIMARY KEY (idClient)
);


------------------------------------------------------------
-- Table: Paris
------------------------------------------------------------
CREATE TABLE Bankroll.Paris(
	idParis      SERIAL ,
	intitule     VARCHAR (128) NOT NULL ,
	Etat         INT2  NOT NULL ,
	Mise         DECIMAL (15,2) NOT NULL ,
	Cote         numeric (10,2)  NOT NULL ,
	DateCreation DATE  NOT NULL ,
	idBankroll   INT  NOT NULL ,
	CONSTRAINT pk_Paris PRIMARY KEY (idParis)
);


------------------------------------------------------------
-- Table: Match
------------------------------------------------------------
CREATE TABLE Bankroll.Match(
	idMatch SERIAL,
	Cote    FLOAT  NOT NULL ,
	Etat    INT2   ,
	type int,
	idParis INT  NOT NULL ,
	CONSTRAINT pk_Match PRIMARY KEY (idMatch)
);


------------------------------------------------------------
-- Table: Bankroll
------------------------------------------------------------
CREATE TABLE Bankroll.Bankroll(
	idBankroll  SERIAL NOT NULL ,
	nomBankroll VARCHAR (128) NOT NULL  ,
	Solde       DECIMAL (15,2) NOT NULL ,
	SoldeDebut DECIMAL (15,2) NOT NULL,
	dateCreation DATE  NOT NULL ,
	idClient    INT  NOT NULL ,
	CONSTRAINT pk_Bankroll PRIMARY KEY (idBankroll),
	CONSTRAINT ck_Bankroll_nomBankroll_idClient UNIQUE (nomBankroll,idClient)
);



------------------------------------------------------------
-- Table: Client_Attempt
------------------------------------------------------------
CREATE TABLE Bankroll.Client_Attempt (
  idClient INTEGER,
  nbAttempt SMALLINT,
  dateEssai TIME DEFAULT localtime,
  messageSent BOOLEAN DEFAULT false,
  CONSTRAINT  pk_Client_Attempt PRIMARY KEY (idClient)
);

------------------------------------------------------------
-- Table: User_Session
------------------------------------------------------------
CREATE TABLE Bankroll.User_Session(
 idClient INTEGER,
 sessionCode varchar(32),
 CONSTRAINT pk_User_Session PRIMARY KEY (idClient)
);



ALTER TABLE Bankroll.Password ADD CONSTRAINT fk_Password_Utilisateur FOREIGN KEY (idClient) REFERENCES Bankroll.Utilisateur (idClient);
ALTER TABLE Bankroll.Paris ADD CONSTRAINT FK_Paris_Bankroll FOREIGN KEY (idBankroll) REFERENCES Bankroll.Bankroll(idBankroll);
ALTER TABLE Bankroll.Match ADD CONSTRAINT FK_Match_Paris FOREIGN KEY (idParis) REFERENCES Bankroll.Paris(idParis);
ALTER TABLE Bankroll.Bankroll ADD CONSTRAINT FK_Bankroll_Client FOREIGN KEY (idClient) REFERENCES Bankroll.Utilisateur(idClient);
ALTER TABLE Bankroll.Bankroll ADD CONSTRAINT ck_Bankroll_solde check (solde >= 0);
ALTER TABLE Bankroll.Bankroll ALTER COLUMN dateCreation set default now();
ALTER TABLE Bankroll.Paris ADD CONSTRAINT ck_Paris_Etat check(etat >= 0 and etat <= 2), ADD CONSTRAINT ck_Paris_mise check (mise > 0), ADD CONSTRAINT ck_Paris_Cote check (cote > 1 ) ; 
ALTER TABLE Bankroll.Paris alter column dateCreation set default now();
ALTER TABLE Bankroll.Match ADD CONSTRAINT ck_Match_Cote check(cote > 1) , ADD CONSTRAINT ck_Match_Etat check(etat >= 0 and etat <=2);
ALTER TABLE Bankroll.Client_Attempt ADD CONSTRAINT fk_Client_Attempt_Utilisateur FOREIGN KEY (idClient) REFERENCES Bankroll.Utilisateur (idClient);
ALTER TABLE Bankroll.User_Session add constraint fk_User_Session_Utilisateur foreign key (idClient) references Bankroll.Utilisateur (idClient);
