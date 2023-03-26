CREATE TABLE user (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  firstName varchar(255),
  lastName varchar(255),
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  biography text,
  twitterAccount varchar(255),
  linkedinAccount varchar(255),
  pgwebAddress varchar(255),
  demeritPoints integer,
  userKey varchar(255) NOT NULL,
  administratorPermissions boolean NOT NULL
  );

CREATE TABLE discussion (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  /* rankingIndex integer NOT NULL, */
  isVisible boolean NOT NULL
);

CREATE TABLE likesManager (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userid integer NOT NULL,
  discussionid integer NOT NULL,
  FOREIGN KEY (userid) REFERENCES user (id),
  FOREIGN KEY (discussionid) REFERENCES discussion (id),
  CONSTRAINT uniqueness UNIQUE(userid, discussionid)
);

CREATE TABLE post (
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  postTitle varchar(255) NOT NULL,
  postContent text NOT NULL,
  createdAt datetime NOT NULL,
  FOREIGN KEY (authorId) REFERENCES user (id),
  FOREIGN KEY (discussionId) REFERENCES discussion (id)
);

CREATE TABLE reply (
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  content varchar(255) NOT NULL,
  createdAt datetime NOT NULL,
  FOREIGN KEY (discussionId) REFERENCES discussion (id),
  FOREIGN KEY (authorId) REFERENCES user (id)
);

CREATE TABLE report (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  content integer NOT NULL,
  reportedAt datetime NOT NULL,
  reviewed boolean,
  FOREIGN KEY (discussionId) REFERENCES discussion (id),
  FOREIGN KEY (authorId) REFERENCES user (id)
);

CREATE TABLE topicType (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  topic varchar(255) NOT NULL
);

CREATE TABLE topicManager (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  discussionId integer NOT NULL,
  topicId integer NOT NULL,
  FOREIGN KEY (discussionId) REFERENCES discussion (id),
  FOREIGN KEY (topicId) REFERENCES topicType (id)
);

INSERT INTO topicType (topic) VALUES ('NEWS');
INSERT INTO topicType (topic) VALUES ('SPACE');
INSERT INTO topicType (topic) VALUES ('SPORTS');
INSERT INTO topicType (topic) VALUES ('Q&A');
INSERT INTO topicType (topic) VALUES ('GAMING');
INSERT INTO topicType (topic) VALUES ('COOKING');
INSERT INTO topicType (topic) VALUES ('POSITIVITY');