

CREATE TABLE plants (
	id SERIAL,
	p_name varchar(255),
	create_timed timestamp DEFAULT NOW(),
	update_time timestamp DEFAULT NOW(),
	p_status varchar(255) DEFAULT 'WATERED',
	PRIMARY KEY (id) 
);


