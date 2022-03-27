CREATE TABLE plants (
	id SERIAL,
	p_name varchar(255),
	last_watered timestamp DEFAULT null,
	p_status varchar(255) DEFAULT 'NOT WATERED',
	PRIMARY KEY (id) 
);

