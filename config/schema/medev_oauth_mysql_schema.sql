CREATE TABLE IF NOT EXISTS OAuth_Users (
	Id INT AUTO_INCREMENT,
	FirstName VARCHAR(255) NOT NULL,
	LastName VARCHAR(255) NOT NULL,
	UserName VARCHAR(255) NOT NULL,
	Email VARCHAR(255) NOT NULL,
	Password VARCHAR(255) NOT NULL,
	Salt VARCHAR(255),
	Status INT NOT NULL DEFAULT 0,
	CreatedAt DATE,
	UpdatedAT DATE,
	PRIMARY KEY(Id),
	UNIQUE (Email)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Scopes (
	Id VARCHAR(200),
	Application VARCHAR(50) NOT NULL,
	Description TEXT,
	CreatedAt DATE,
	UpdatedAt DATE,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Clients (
	Id VARCHAR(100),
	Name VARCHAR(255) NOT NULL,
	Secret VARCHAR(255), 
	RedirectURI VARCHAR(255),
	Status INT NOT NULL DEFAULT 0,
	CreatedAt DATE,
	UpdatedAt DATE,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_AccessTokens (
	Id VARCHAR(255),
	UserId INT NOT NULL,
	ClientId INT NOT NULL,
	Expiration DATE NOT NULL,
	CreatedAt DATE NOT NULL,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_RefreshTokens (
	Id VARCHAR(255),
	UserId INT NOT NULL,
	ClientId INT NOT NULL,
	Expiration DATE NOT NULL,
	CreatedAt DATE NOT NULL,
	PRIMARY KEY (Id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_Clients_Users (
	UserId INT NOT NULL,
	ClientId INT NOT NULL,
	PRIMARY KEY (UserId, ClientId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_UserScopes(
	UserId INT NOT NULL,
	ScopeId INT NOT NULL,
	PRIMARY KEY (UserId, ScopeId)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS OAuth_ClientScopes(
	ClientId INT NOT NULL,
	UserId INT NOT NULL,
	ScopeId INT NOT NULL,
	PRIMARY KEY (ClientId, UserId, ScopeId)
) ENGINE=INNODB;

