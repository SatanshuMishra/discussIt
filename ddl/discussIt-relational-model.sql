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
  demeritPoints integer DEFAULT 0 NOT NULL,
  userKey varchar(255) NOT NULL,
  isSuspended boolean DEFAULT FALSE NOT NULL,
  administratorPermissions boolean DEFAULT FALSE NOT NULL
  );

CREATE TABLE discussion (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  isVisible boolean DEFAULT TRUE
);

CREATE TABLE post (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  postTitle varchar(255) NOT NULL,
  postContent text NOT NULL,
  createdAt datetime DEFAULT NOW() NOT NULL,
  FOREIGN KEY (authorId) REFERENCES user (id),
  FOREIGN KEY (discussionId) REFERENCES discussion (id)
);

CREATE TABLE reply (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  replyTo integer,
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  content varchar(255) NOT NULL,
  createdAt datetime DEFAULT NOW() NOT NULL,
  FOREIGN KEY (discussionId) REFERENCES discussion (id),
  FOREIGN KEY (authorId) REFERENCES user (id),
  FOREIGN KEY (replyTo) REFERENCES reply (id)
);

CREATE TABLE discussionReactionManager (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userid integer NOT NULL,
  discussionid integer NOT NULL,
  FOREIGN KEY (userid) REFERENCES user (id),
  FOREIGN KEY (discussionid) REFERENCES discussion (id),
  CONSTRAINT uniqueness UNIQUE(userid, discussionid)
);

CREATE TABLE replyReactionManager (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userid integer NOT NULL,
  discussionid integer NOT NULL,
  replyid integer NOT NULL,
  FOREIGN KEY (userid) REFERENCES user (id),
  FOREIGN KEY (discussionid) REFERENCES discussion (id),
  FOREIGN KEY (replyid) REFERENCES reply (id),
  CONSTRAINT uniqueness UNIQUE(userid, discussionid)
);

CREATE TABLE report (
  id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  discussionId integer NOT NULL,
  authorId integer NOT NULL,
  content integer NOT NULL,
  reportedAt datetime DEFAULT NOW() NOT NULL,
  reviewed boolean DEFAULT FALSE NOT NULL,
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