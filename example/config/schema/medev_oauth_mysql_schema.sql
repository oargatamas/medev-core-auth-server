DROP TABLE IF EXISTS OAuth_Users;
DROP TABLE IF EXISTS OAuth_Scopes;
DROP TABLE IF EXISTS OAuth_Clients;
DROP TABLE IF EXISTS OAuth_AuthCodes;
DROP TABLE IF EXISTS OAuth_AccessTokens;
DROP TABLE IF EXISTS OAuth_RefreshTokens;
DROP TABLE IF EXISTS OAuth_Clients_Users;
DROP TABLE IF EXISTS OAuth_UserScopes;
DROP TABLE IF EXISTS OAuth_ClientScopes;
DROP TABLE IF EXISTS OAuth_GrantTypes;
DROP TABLE IF EXISTS OAuth_ClientGrantTypes;


CREATE TABLE IF NOT EXISTS OAuth_Users (
	Id INT AUTO_INCREMENT,
	FirstName VARCHAR(255) NOT NULL,
	LastName VARCHAR(255) NOT NULL,
	UserName VARCHAR(255) NOT NULL,
	Email VARCHAR(255) NOT NULL,
	Password VARCHAR(255) NOT NULL,
	Verified TINYINT(1) DEFAULT 0,
	Disabled TINYINT(1) DEFAULT 0,
	CreatedAt DATETIME,
	UpdatedAT DATETIME,
	PRIMARY KEY(Id),
	UNIQUE (Email)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Scopes (
	Id VARCHAR(200),
	Application VARCHAR(50) NOT NULL,
	Description TEXT,
	CreatedAt DATETIME,
	UpdatedAt DATETIME,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Clients (
	Id VARCHAR(100),
	Name VARCHAR(255) NOT NULL,
	Secret VARCHAR(255), 
	RedirectURI VARCHAR(255),
	Status INT NOT NULL DEFAULT 0,
	TokenPlace VARCHAR(10) NOT NULL DEFAULT 'req-body',
	CreatedAt DATETIME,
	UpdatedAt DATETIME,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_AuthCodes (
	Id VARCHAR(20),
	UserId INT NOT NULL,
	ClientId VARCHAR(100),
	RedirectURI VARCHAR(255),
	IsRevoked TINYINT(1) DEFAULT 1,
	CreatedAt DATETIME NOT NULL,
	ExpiresAt DATETIME NOT NULL,
	PRIMARY KEY (Id, ClientId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_AccessTokens (
	Id VARCHAR(255),
	UserId INT NOT NULL,
	ClientId INT NOT NULL,
	ExpiresAt DATETIME NOT NULL,
	CreatedAt DATETIME NOT NULL,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_RefreshTokens (
	Id VARCHAR(255),
	UserId INT NOT NULL,
	ClientId VARCHAR(100) NOT NULL,
	IsRevoked TINYINT(1) DEFAULT 1,
	CreatedAt DATETIME NOT NULL,
	ExpiresAt DATETIME NOT NULL,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_IdTokens(
  Id VARCHAR(255),
  UserId INT NOT NULL,
  ClientId VARCHAR(100) NOT NULL,
  IsRevoked TINYINT(1) DEFAULT 1,
  CreatedAt DATETIME NOT NULL,
  ExpiresAt DATETIME NOT NULL,
  PRIMARY KEY(Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Clients_Users (
	UserId INT NOT NULL,
	ClientId INT NOT NULL,
	PRIMARY KEY (UserId, ClientId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_UserScopes(
	UserId INT NOT NULL,
	ScopeId VARCHAR(200) NOT NULL,
	PRIMARY KEY (UserId, ScopeId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_ClientScopes(
	ClientId VARCHAR(100) NOT NULL,
	UserId INT NOT NULL,
	ScopeId VARCHAR(200) NOT NULL,
	PRIMARY KEY (ClientId, UserId, ScopeId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_GrantTypes(
  Id INT NOT NULL,
  GrantName VARCHAR(20) NOT NULL,
  PRIMARY  KEY (Id),
  UNIQUE (GrantName)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_ClientGrantTypes(
  ClientId VARCHAR(100) NOT NULL,
  GrantId INT NOT NULL,
  PRIMARY KEY (ClientId, GrantId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_LoginTypes(
  Id INT NOT NULL,
  LoginName VARCHAR(20) NOT NULL,
  PRIMARY  KEY (Id),
  UNIQUE (LoginName)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Client_LoginTypes(
  ClientId VARCHAR(100) NOT NULL,
  LoginId INT NOT NULL,
  PRIMARY KEY (ClientId, LoginId)
) ENGINE=INNODB;

INSERT INTO OAuth_LoginTypes VALUES (1,'password');
INSERT INTO OAuth_LoginTypes VALUES (2,'authcode');

INSERT INTO OAuth_GrantTypes VALUES (1,'authorization_code');
INSERT INTO OAuth_GrantTypes VALUES (2,'password');
INSERT INTO OAuth_GrantTypes VALUES (3,'client_credentials');
INSERT INTO OAuth_GrantTypes VALUES (4,'refresh_token');

INSERT INTO OAuth_Users VALUES ('1','Tamás','Oarga','Tangomajom','toarga@medev.hu','$2y$12$PtR0KlIvg22oI.y.ukJ0A.s5JsalVCNkKE.wGz5R/9nz5cs3mxBJm','1','0','2019-02-26','2019-02-26');
INSERT INTO OAuth_Clients VALUES ('hu.medev.office.webclient', 'OfficeMedevApplication', '$2y$12$1TUfojssKlhWYaRKLG0wq.8mxt/ErN.9HUZza0MniFRYCK9tsY6He', 'https://office.medev.local', '1', 'req-body', '2021-05-21 15:46:54.000000', '2021-05-21 15:46:54.000000')
