<div>
	<h1>Je KdG hosting is aangemaakt!</h1>

	<div>
		<h2>Je gegevens</h2>
		<p><strong>Naam:</strong> {{ $account->name }}</p>
		<p><strong>E-mail:</strong> {{ $account->email }}</p>
		<p><strong>Domein:</strong> {{ $account->domain }}</p>
		<p><strong>Gebruikersnaam:</strong> {{ $account->username }}</p>
		<p><strong>FTP gebruiker:</strong> {{ $account->ftp_user }}</p>
		<p><strong>FTP server:</strong> {{ $account->ftp_server }}</p>
	</div>

	<div>
		<h2>Wat nu?</h2>
		<ul>
			<li>Je wachtwoord instellen kan je als je je de eerste keer inlogt op <a href="https://www.combell.com/nl/">Combell</a>. Je gebruikersnaam is <strong>{{ $account->username }}</strong>.</li>
			<li>Het kan zijn dat je na het ontvangen van deze mail nog een paar uur moet wachten voordat je je kan inloggen.</li>
			<li>Als je je aanmeldt vind je je hosting terug onder "Mijn producten" en dan "Webhosting".</li>
			<li>In de details van je hosting kan je in de navigatie, onder "PHP-instellingen", je PHP versie aanpassen. (Als je codeert in PHP versie 7.2 maar je hosting staat op 7.1 kan het goed zijn dat je website niet gaat werken.)</li>
			<li>In de navigatie, onder "SSH", kan je best SSH activeren. (Met SSH kan je bepaalde Linux commando's op de server uitvoeren.)</li>
		</ul>
	</div>
</div>
