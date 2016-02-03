DROP TABLE IF EXISTS `acc` ;
CREATE TABLE IF NOT EXISTS `acc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `method` char(16) NOT NULL DEFAULT '',
  `from_tag` char(64) NOT NULL DEFAULT '',
  `to_tag` char(64) NOT NULL DEFAULT '',
  `callid` char(64) NOT NULL DEFAULT '',
  `sip_code` char(3) NOT NULL DEFAULT '',
  `sip_reason` char(32) NOT NULL DEFAULT '',
  `time` datetime NOT NULL,
  `cdr_id` bigint(11) NOT NULL DEFAULT '0',
  `duration` int(11) unsigned NOT NULL DEFAULT '0',
  `setuptime` int(11) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `callid_idx` (`callid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  `acc` ADD  `src_uri` VARCHAR( 128 ) NOT NULL ,
ADD  `dst_uri` VARCHAR( 128 ) NOT NULL ,
ADD  `caller_domain` VARCHAR( 128 ) NOT NULL ,
ADD  `callee_domain` VARCHAR( 128 ) NOT NULL ;

ALTER TABLE  `missed_calls` ADD  `src_uri` VARCHAR( 128 ) NOT NULL ,
ADD  `dst_uri` VARCHAR( 128 ) NOT NULL ,
ADD  `caller_domain` VARCHAR( 128 ) NOT NULL ,
ADD  `callee_domain` VARCHAR( 128 ) NOT NULL ;
