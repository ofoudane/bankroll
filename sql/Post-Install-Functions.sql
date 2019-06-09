CREATE or replace FUNCTION addUser(mail Bankroll.utilisateur.mail%type,firstName Bankroll.utilisateur.nom%type,lastName Bankroll.utilisateur.prenom%type,password varchar) returns boolean as $$
declare
	idUser Bankroll.utilisateur.idclient%type;
	idPass Bankroll.utilisateur.idclient%type;
	successful boolean;
	maxLength constant int := 30;
begin
	if(length(password)>maxLength) then
		successful := 'false';
	else
		idUser := -1;
			insert into bankroll.utilisateur values (default,mail,firstName,lastName) returning idclient into idUser;
		if(idUser != -1 ) then
			insert into Bankroll.password values(idUser,md5(password)) returning idClient into idPass;
			if(idPass = idUser) then
				successful := 'true';
			else
				successful := 'false';
			end if;
		else
			successful := 'false';
		end if;
	end if;
	return successful;
end; $$ language plpgsql;

CREATE OR REPLACE  FUNCTION authenticateUser(userMail Bankroll.utilisateur.mail%type,motDePasse varchar) returns varchar as $$
DECLARE
	answer varchar := 'refused';
	idUser integer;
	formalPass VARCHAR;
	nbEssaie SMALLINT;
	messageEnvoye BOOLEAN;
	dateTentative timestamp;
BEGIN
	select idClient into idUser from bankroll.utilisateur where mail = userMail;
	if(found) THEN
		select nbAttempt,dateEssai into nbEssaie,dateTentative from bankroll.client_Attempt where idClient = idUser;
		if(not FOUND) THEN
			nbEssaie := 0 ;
		ELSE
			dateTentative := dateTentative + Interval'7200';
			if(dateTentative < now() ) THEN
				update bankroll.Client_Attempt set nbAttempt = 0, messageSent = 'false';
				nbEssaie := 0 ;
			END IF;
		END IF;

		if(nbEssaie > 4 ) THEN
			select messageSent into messageEnvoye from bankroll.client_Attempt where idClient = idUser;
			if(messageEnvoye) THEN
				answer := 'blocked';
			ELSE
				answer :='send';
			END IF;
		else
			select Pass into formalPass from bankroll.password where idClient = idUser;
			if(formalPass = MD5(motDePasse)) THEN
				select MD5(random()::text) into answer ;
				perform sessionCode from bankroll.User_Session where idClient = idUser;
				if(not found) then
					insert into bankroll.User_Session values (idUser,answer);
				else
					update bankroll.User_Session set sessionCode = answer where idClient = idUser;
					delete from bankroll.Client_Attempt where idClient = idUser;
				END IF;
			else
				perform * from bankroll.Client_Attempt where idClient = idUser;
				if(found) then
					update bankroll.Client_Attempt set nbAttempt = nbAttempt + 1 where idClient = idUser;
				ELSE
					insert into bankroll.Client_Attempt values (idUser,0,default,default);
				END IF;
			END IF;
		END IF;
	ELSE
		answer := 'inexistant';
	END IF ;
	return answer;
END; $$ language plpgsql;


CREATE OR REPLACE FUNCTION verifieSession(email bankroll.utilisateur.mail%type, userSessionCode varchar) returns boolean as $$
declare
	answer boolean := false;
	idUser bankroll.utilisateur.idClient%type;
begin
	select idClient into idUser from bankroll.utilisateur where mail = email;
	if(found) then
		perform * from bankroll.User_Session where idClient = idUser and sessionCode = userSessionCode ;
		answer := found;
	end if;
	return answer;
end; $$ language plpgsql;

CREATE OR REPLACE FUNCTION addBankroll(nom varchar,soldeDeDepart bankroll.bankroll.solde%type,email bankroll.utilisateur.mail%type,userSessionCode varchar ) returns boolean as $$
declare
valid boolean;
newIdBankroll integer;
idUser integer;
created boolean := 'false';
begin
	select verifieSession(email,userSessionCode) into valid;
	if(valid) then
		select getIdClient(email) into idUser;
		perform idClient from bankroll.bankroll where nomBankroll = nom and idClient = idUser;
		if (not found) then
			insert into bankroll.bankroll values(default,nom,soldeDeDepart,soldeDeDepart,now(),idUser) returning idBankroll into newIdBankroll;
			if(newIdBankroll > 0 ) then
				created := 'true';
			end if;
		end if;
	end if;
return created;
end; $$ language plpgsql;

CREATE OR REPLACE FUNCTION setMailSent(userMail bankroll.utilisateur.mail%type) returns void as $$
declare
  userId integer;
begin
  select idClient into userId from bankroll.utilisateur where mail = userMail;
  update bankroll.client_attempt set messageSent = 'true' where idClient = userId;
end;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION getIdClient(email bankroll.utilisateur.mail%type) returns integer as $$
	select idClient from bankroll.utilisateur where mail = email;
$$ language sql;


CREATE  or REPLACE  FUNCTION cashoutBankroll(nom bankroll.bankroll.nombankroll%type,montant numeric , mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns boolean as $$
DECLARE
  idCl integer;
  verified boolean;
  updated boolean := 'false' ;
	newIdClient integer;
BEGIN
  select verifieSession(mail,sessionCode) into verified;
  if(verified) THEN
    select getIdClient(mail) into idCl;
    perform * from bankroll.bankroll where idClient = idCl and nomBankroll = nom and solde >= montant;
    IF(FOUND) THEN
      update bankroll.bankroll set solde = solde - montant,soldeDebut = soldeDebut - montant where idClient = idCl and nomBankroll = nom returning idClient into newIdClient;
			updated := newIdClient is not NULL ;
    END IF;
  END IF;
  return updated;
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION getBankrolls(mail Bankroll.Utilisateur.mail%type,sessionId bankroll.User_Session.sessionCode%type) returns table(id bankroll.Bankroll.idbankroll%type,nom bankroll.Bankroll.nomBankroll%type,soldeActuelle Bankroll.Bankroll.solde%type , soldeDepart Bankroll.Bankroll.soldedebut%type) as $$
declare
  idCl integer := -1 ;
  verified boolean;
begin
  select verifieSession(mail,sessionId) into verified;
  if(verified) THEN
    select getIdClient(mail) into idCl;
  END IF;
  return query select idbankroll , nombankroll,solde,soldedebut from bankroll.bankroll where idClient = idCl;
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION deleteBankroll(id bankroll.bankroll.idBankroll%type,mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns boolean as $$
DECLARE
  verified boolean;
  deleted boolean := false;
BEGIN
  select verifieSession(mail,sessionCode) into verified;
  if(verified) THEN
		delete from bankroll.paris where idbankroll = id;
		delete from bankroll.bankroll where idbankroll = id;
    perform * from bankroll.bankroll where idbankroll = id;
    deleted := not found;
  END IF;
  return deleted;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION addMoneyToBankroll(nom bankroll.bankroll.nombankroll%type,montant numeric , mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns boolean as $$
  select cashoutBankroll(nom,-montant,mail,sessionCode);
$$ LANGUAGE sql;


CREATE OR REPLACE FUNCTION getBankrollNames(mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns table(nom bankroll.bankroll.nomBankroll%type) as $$
DECLARE
	verified boolean;
	idCl integer := -1;
BEGIN
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		 select getIdClient(mail) into idCl;
	END IF;
	return query select nomBankroll from bankroll.bankroll where idClient = idCl ORDER BY solde desc;
END; $$ language plpgsql;

CREATE OR REPLACE FUNCTION getBankrollId(nomBank bankroll.bankroll.nomBankroll%type,idCl bankroll.bankroll.idClient%type) returns integer as $$
	select idBankroll from bankroll.bankroll where nomBankroll = nomBank and idClient = idCl;
$$ language sql;


CREATE OR REPLACE FUNCTION getBankrollNumericInformation(nomBankroll bankroll.bankroll.nomBankroll%type,mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type ) returns table(nbParis BIGINT ,monSolde bankroll.bankroll.solde%type,benefice numeric) as $$
DECLARE
	verified boolean;
	idClient integer;
	idBank integer := 0;

begin
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		select getIdClient(mail) into idClient;
		select getBankrollId(nomBankroll,idClient) into idBank;
	END IF ;
	return query select * from (select count(idparis) from bankroll.paris where idbankroll = idBank) as t1 cross join (select solde,solde - soldeDebut from bankroll.bankroll where idbankroll = idbank) as t2 ;

END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION getGlobalStats(nomBankroll bankroll.bankroll.nomBankroll%type,mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type ) returns varchar as $$
DECLARE
	nbGagnes BIGINT := 0 ;
	nbPerdus BIGINT := 0 ;
	nbRembourses BIGINT := 0;
	montantGagne numeric := 0;
	montantPerdu numeric := 0 ;
	montantRembourse numeric := 0;
	idbank integer;
	idCl integer;
	verified boolean;
BEGIN
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		select getIdClient(mail) into idCl;
		select getBankrollId(nomBankroll,idCl) into idbank;
		select count(idParis) into nbPerdus from bankroll.paris where etat = 0 and idbankroll = idbank ;
		select count(idParis) into nbGagnes from bankroll.paris where etat = 1 and idbankroll = idbank ;
		select count(idParis) into nbRembourses from bankroll.paris where etat = 2 and idbankroll = idbank ;
		select sum(mise) into montantPerdu from bankroll.paris where etat = 0 and idbankroll = idbank ;
		if(montantPerdu is null) THEN
			montantPerdu := 0 ;
		END IF;
		select sum(mise*cote) into montantGagne from bankroll.paris where etat = 1 and idbankroll = idbank;
		if(montantGagne is null) THEN
			montantGagne := 0 ;
		END IF;
		select sum(mise) into montantRembourse from bankroll.paris where etat = 2 and idbankroll = idbank;
		if(montantRembourse is null) THEN
			montantRembourse := 0 ;
		END IF;
	END IF;
	return nbPerdus || ',' || nbGagnes || ',' || nbRembourses || ';' || montantPerdu || ',' || montantGagne || ',' || montantRembourse;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION getBenefice(noParis bankroll.paris.idparis%type) returns numeric as $$
	select case etat when 1 then mise*cote when 0 then -mise when 2 then 0 end from bankroll.paris where idParis = noParis;
$$ language sql;

CREATE OR REPLACE FUNCTION sortBankrollByDate(nomBankroll bankroll.bankroll.nomBankroll%type,mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns text as $$
DECLARE
	daysOfTheWeek varchar := '';
	valueOfTheWeek varchar := '' ;
	years varchar := '';
	valueOfTheYears varchar := '';
	monthsOfTheYear varchar := '';
	valueOfTheMonths varchar := '';
	dateBegin date;
	dateEnd date ;
	idCl integer;
	idBank integer;
	verified boolean;
	benefice numeric;
	dateNum integer;
	dateFullName varchar;
begin
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		select getIdClient(mail) into idCl;
		select getBankrollId(nomBankroll,idCl) into idBank;
		dateBegin := now() + Interval '1 day';
		dateEnd := now() + Interval '1 day';
		for i in 1..7 loop
			select dateBegin -  interval '1 day' into dateBegin;
			select sum(getBenefice(idparis)) into benefice from bankroll.paris where dateCreation > dateBegin and dateCreation <= dateEnd and idBankroll = idBank ;
			if(benefice is null) then
				benefice := 0 ;
			end if;
			select substring(to_char(dateEnd,'DAY'),0,4) into dateFullName;
			dateEnd := dateBegin;
			daysOfTheWeek := dateFullName || '|' || daysOfTheWeek ;
			valueOfTheWeek := benefice || '|' || valueOfTheWeek;
		end loop;
		dateBegin := now() + interval '2 month';
		dateEnd := now() + interval '2 month';
		for i in 1..10 loop
			select dateBegin - interval '1 month' into dateBegin;
			select sum(getBenefice(idparis)) into benefice from bankroll.paris where dateCreation > dateBegin and dateCreation <= dateEnd and idBankroll = idBank;
			if(benefice is null) then
				benefice := 0 ;
			end if;
			select to_char(dateEnd,'MM') into dateNum;
			dateEnd := dateBegin;
			monthsOfTheYear := dateNum || '|' || monthsOfTheYear ;
			valueOfTheMonths := benefice || '|' || valueOfTheMonths;
		end loop;
		dateBegin := now() + Interval '1 year';
		dateEnd := now() + Interval '1 year';
		for i in 1..5 loop
			select dateBegin -  interval '1 year' into dateBegin;
			select sum(getBenefice(idparis)) into benefice from bankroll.paris where dateCreation > dateBegin and dateCreation <= dateEnd and idBankroll = idBank ;
			if(benefice is null) then
				benefice := 0 ;
			end if;
			select to_char(dateEnd,'YYYY') into dateNum;
			dateEnd := dateBegin;
			years := dateNum || '|' || years;
			valueOfTheYears  := benefice || '|' || valueOfTheYears;
		end loop;
	END IF;
	return daysOfTheWeek || ',' || valueOfTheWeek || ';' || monthsOfTheYear || ',' || valueOfTheMonths || ';' || years || ',' || valueOfTheYears ;
END;
$$ language plpgsql;


CREATE OR REPLACE FUNCTION updateSoldeBankroll(idParis integer,idBank integer) returns void as $$
declare
	montant numeric;
BEGIN
	select getBenefice(idParis) into montant;
	update bankroll.bankroll set solde = solde + montant where idBankroll = idBank;
END;

$$ LANGUAGE  plpgsql;

CREATE OR REPLACE FUNCTION addParis(nomParis bankroll.paris.intitule%type,nomBank bankroll.bankroll.nomBankroll%type,mise bankroll.paris.mise%type ,cote bankroll.paris.cote%type , etat bankroll.paris.etat%type, mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns boolean as $$
DECLARE
	idCl integer;
	idBank integer;
	verified boolean;
	idPari integer;
	answer boolean := 'false';
BEGIN
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		select getIdClient(mail) into idCl;
		select getBankrollId(nomBank,idCl) into idBank;
		if(idbank is not NULL ) then
			insert into bankroll.paris values (default,nomParis,etat,mise,cote,now(),idBank) returning idParis into idPari;
			answer := idPari is not null;
			perform updateSoldeBankroll(idPari,idBank);
		END IF ;
	END IF;
	return answer;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION getParisParEtat(nom bankroll.bankroll.nomBankroll%type,etatParis integer ,mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns table(id integer,intitul  varchar,miseParis numeric,gain numeric) as $$
DECLARE
	idCl integer;
	idBank integer;
	verified boolean;
BEGIN
	select verifieSession(mail,sessionCode) into verified;
	if(verified) THEN
		select getIdClient(mail) into idCl;
		select getBankrollId(nom,idCl) into idBank;
	END IF;
	if(idBank is NULL ) then
		idBank := -1;
	END IF ;
	return query select idParis,intitule,mise,mise*cote from bankroll.paris where idbankroll = idBank and etat = etatParis;
END;
$$ LANGUAGE plpgsql;

create or replace function deleteParis(idPari bankroll.paris.idparis%type,mail bankroll.utilisateur.mail%type,sessionCode varchar) returns boolean as $$ 
declare
idCl integer;
verified boolean;
newIdClient integer;
idBank integer;
montantParis numeric;
begin
	select verifieSession(mail,sessionCode) into verified; 
	if(verified) then
		select getIdClient(mail) into idCl;
		select idClient into newIdClient from bankroll.paris natural join bankroll.bankroll where idParis = idPari ;
		if(newIdClient = idCl) then
			select getBenefice(idPari) into montantParis;
			delete from bankroll.paris where idParis = idPari returning idBankroll into idBank;
			if(idBank is not null) then
				update bankroll.bankroll set solde = solde - montantParis where idBankroll = idbank;
			end if;
		end if;
	end if;
	return idBank is not null;
end;
$$ language plpgsql;

create or replace function resetPassword(key varchar,mail bankroll.utilisateur.mail%type) returns varchar as $$
declare
isCorrect boolean;
idCl integer;
newPass varchar;
newIdClient integer;
answer varchar := '';
begin
	select getIdClient(mail) into idCl;
	perform * from bankroll.password where idClient = idCl and clerecup = key;
	if(found) then
		select substring(MD5(random()::text),0,10) into newPass;
		update bankroll.password set pass = MD5(newPass),clerecup = generateKey() where idClient = idCl returning idCl into newIdClient;
		if(newIdClient is not null) then
			answer := newPass;
		end if;
	end if;
	return answer;
end;
$$ language plpgsql;


create or replace function changePassword(motDePasse varchar,key varchar,mail bankroll.utilisateur.mail%type,sessionCode varchar) returns boolean as $$ 
declare
verified boolean;
idCl integer;
newIdClient integer;
begin
	select verifieSession(mail,sessionCode) into verified;
	if(verified) then
		select getIdClient(mail) into idCl;
		update bankroll.password set pass = MD5(motDePasse),clerecup = generateKey() where clerecup = key and idClient = idCl returning idClient into newIdClient;
	end if;
	return newIdClient is not null;
end;
$$ language plpgsql;


/*
CREATE OR REPLACE FUNCTION verifieEtat(etats integer[]) returns boolean as $$
DECLARE
BEGIN
	foreach i in array etats
	LOOP
		if(i<0 or i >2) then
			return 'false';
			end if;
	END LOOP;
	return 'true';
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION verifieCote(cotes numeric[]) returns boolean as $$
DECLARE
BEGIN
	foreach i in array cotes
	LOOP
		if(i < 1 ) then
			return 'false';
		end if;
	END LOOP;
	return 'true';
END;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION addMatchs(nomParie bankroll.paris.nomParis%type,nomBank bankroll.bankroll.nomBankroll%type, mise bankroll.paris.mise%type,cotes numeric[],etats integer[],typeParis integer , mail bankroll.utilisateur.mail%type,sessionCode bankroll.user_session.sessionCode%type) returns boolean as $$
declare
	idCl integer;
	idBank integer;
	verified boolean;
	verifiedCotes boolean ;
	verifiedEtats boolean ;
	idParie integer;
	lengthCote integer;
	lengthEtats integer;
	i integer;
	idMat integer;
	inserted boolean := true;
begin
	select verifieSession(mail,sessionCode) into verified;
	if(verified)THEN
		select getIdClient(mail) into idCl;
		select getBankrollId(nomBank,idCl) into idBank;
		select verifiedEtats(etats) into verifiedEtats;
		if(verifiedEtats) THEN
			select verifiedCotes(cotes) into verifiedCotes;
			if(verifiedCotes) THEN
				insert into bankroll.paris values (default,nomParie,2,mise,1.1,now(),idBank) returning idParis into idParie;
				if(paris is not NULL ) THEN
					lengthCote := array_length(cotes);
					lengthEtats := array_length(etats);
					if(lengthCote = lengthEtats) THEN
						for i in 1..lengthCote
						LOOP
							insert into bankroll.match values (default,cotes[i],etats[i],typeParis,idParie) returning idMatch into idMat;
							if(idMat is NULL )THEN
								delete from bankroll.match where idparis = idParie;
								delete from bankroll.paris where idparis = idParie;
								return 'false';
							ELSE
								perform updateCoteEtatParis(idParie);
							END IF;
						END LOOP;
					ELSE
						inserted := 'false';
					END IF;
				ELSE
					inserted := 'false';
				END IF;
			ELSE
				inserted := 'false';
			END IF;
			else
			inserted := 'false';
		END IF;
	ELSE
		inserted := 'false';
	END IF;
	return inserted;
END;
$$ LANGUAGE plpgsql;

create or replace function updateCoteEtatParis(idParie integer) returns boolean as $$
DECLARE
	coteTotal numeric;
	typeParis integer;
	etatTotal integer;
	winMatch integer;
BEGIN
	select distinct(type) into typeParis from bankroll.match where idparis = idParie;
	if(typeParis = 0) THEN
		perform * from bankroll.paris where idparis = idParie and etat = 1;
		if(found) THEN
			coteTotal :=
		END IF;
	END IF;
END;

$$ language plpgsql;
*/
