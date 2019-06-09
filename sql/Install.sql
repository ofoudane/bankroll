CREATE USER bankroll password 'B@nkr0l1';
CREATE DATABASE bankroll with owner bankroll encoding 'utf-8';
\c bankroll
\i Pre-Install-Functions.sql
\i Schema.sql
\i Post-Install-Functions.sql


GRANT ALL ON ALL TABLES IN SCHEMA BANKROLL TO bankroll;
GRANT ALL ON ALL SEQUENCES IN SCHEMA BANKROLL TO bankroll;
GRANT ALL ON DATABASE BANKROLL TO bankroll;
GRANT ALL ON SCHEMA BANKROLL to bankroll;
