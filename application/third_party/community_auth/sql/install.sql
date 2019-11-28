--
-- Community Auth - MySQL database setup
--
-- Community Auth is an open source authentication application for CodeIgniter 3
--
-- @package     Community Auth
-- @author      Robert B Gottier
-- @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
-- @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
-- @link        http://community-auth.com
--

--
-- Table structure for table ci_sessions
--
-- Note that if sess_match_ip == true, then the 
-- primary key for ci_sessions needs to be changed after table creation:
--
-- ALTER TABLE ci_sessions DROP PRIMARY KEY;
-- ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address);

CREATE TABLE IF NOT EXISTS ci_sessions (
  id varchar(128) NOT NULL,
  ip_address varchar(45) NOT NULL,
  timestamp INTEGER DEFAULT 0 NOT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table auth_sessions
--
-- The IP address and user agent are only 
-- included so that sessions can be identified.
-- This can be helpful if you want to show the 
-- user their sessions, and allow them to terminate
-- selected sessions.
--

CREATE TABLE IF NOT EXISTS auth_sessions (
  id varchar(128) NOT NULL,
  user_id INTEGER NOT NULL,
  login_time TIMESTAMP DEFAULT NULL,
  modified_at timestamp DEFAULT NULL,
  ip_address varchar(45) NOT NULL,
  user_agent varchar(60) DEFAULT NULL,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table ips_on_hold
--

CREATE TABLE IF NOT EXISTS ips_on_hold (
  ai SERIAL,
  ip_address varchar(45) NOT NULL,
  time TIMESTAMP NOT NULL,
  PRIMARY KEY (ai)
);

-- --------------------------------------------------------

--
-- Table structure for table login_errors
--

CREATE TABLE IF NOT EXISTS login_errors (
  ai SERIAL,
  username_or_email varchar(255) NOT NULL,
  ip_address varchar(45) NOT NULL,
  time TIMESTAMP NOT NULL,
  PRIMARY KEY (ai)
);

-- --------------------------------------------------------

--
-- Table structure for table denied_access
--

CREATE TABLE IF NOT EXISTS denied_access (
  ai SERIAL,
  ip_address varchar(45) NOT NULL,
  time TIMESTAMP NOT NULL,
  reason_code INTEGER DEFAULT 0,
  PRIMARY KEY (ai)
);

-- --------------------------------------------------------

--
-- Table structure for table username_or_email_on_hold
--

CREATE TABLE IF NOT EXISTS username_or_email_on_hold (
  ai SERIAL,
  username_or_email varchar(255) NOT NULL,
  time TIMESTAMP NOT NULL,
  PRIMARY KEY (ai)
);

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE IF NOT EXISTS users (
  user_id SERIAL,
  username varchar(12) DEFAULT NULL,
  email varchar(255) NOT NULL,
  auth_level INTEGER NOT NULL,
  banned BOOLEAN NOT NULL DEFAULT '0',
  passwd varchar(60) NOT NULL,
  passwd_recovery_code varchar(60) DEFAULT NULL,
  passwd_recovery_date TIMESTAMP DEFAULT NULL,
  passwd_modified_at TIMESTAMP DEFAULT NULL,
  last_login TIMESTAMP DEFAULT NULL,
  created_at TIMESTAMP NOT NULL,
  modified_at TIMESTAMP DEFAULT NULL,
  PRIMARY KEY (user_id)
);

-- --------------------------------------------------------

--
-- Table structure for table acl_categories
-- 

CREATE TABLE acl_categories (
  category_id SERIAL,
  category_code varchar(100) NOT NULL,
  category_desc varchar(100) NOT NULL,
  PRIMARY KEY (category_id)
);

-- --------------------------------------------------------

--
-- Table structure for table acl_actions
-- 

CREATE TABLE acl_actions (
  action_id SERIAL,
  action_code varchar(100) NOT NULL,
  action_desc varchar(100) NOT NULL,
  category_id INTEGER NOT NULL,
  PRIMARY KEY (action_id),
  FOREIGN KEY (category_id) REFERENCES acl_categories(category_id) 
  ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table acl
-- 

CREATE TABLE acl (
  ai SERIAL,
  action_id INTEGER NOT NULL,
  user_id INTEGER DEFAULT NULL,
  PRIMARY KEY (ai),
  FOREIGN KEY (action_id) REFERENCES acl_actions(action_id) 
  ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(user_id) 
  ON DELETE CASCADE
);

-- --------------------------------------------------------
