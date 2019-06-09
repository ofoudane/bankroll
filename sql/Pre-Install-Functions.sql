CREATE OR REPLACE FUNCTION generateKey() returns varchar as $$
	select MD5(random()::text)||MD5(random()::text);
$$ language SQL;
