<?php $this->load->view("partial/header"); ?>
<style>
ul li {
	list-style-position: inside !important;
}
</style>
<br/><br/>
<h1>Configuring Repeatable Campaigns</h1>

<p>Repeatable campaigns pull information from the date the campaign is built, and, depending on the range, the data from the last 7 days or last month. Creating a repeatable campaign from a report simply queues the data for the next time the daily, weekly, and monthly campaign reports are built. There are two ways to run these builds:</p><br/>
<ul>
	<li>Manually run the report. This guarantees that the reports run at the day and time you want.</li>
	<li>Schedule the report using a service like <tt>cron</tt>. If this is not something you are already familiar with, you should likely opt for running the report manually.</li>
</ul>
<br/><br/>
<h3>Running Report Builds Manually</h3>
<p>There are three kinds of reports: daily, weekly, and monthly. In order to run these reports, you need to have <a href="http://phing.info">Phing</a> installed. You can easily install this using the instructions on the Phing website. Once you have phing installed, you can call one of three commands (their functions are self-explanatory):</p><br/>
<ul>
	<li>./phing dailyCampaign</li>
	<li>./phing weeklyCampaign</li>
	<li>./phing monthlyCampaign</li>
</ul>
<br/>
<p>It is important to include the "./", as a script in the code base sets up all necessary environment information. When each of these builds is run, all campaigns that have been queued for the selected interval will be run, populating the data to create the reports, and immediately sending the report to the list you provided. <b>This cannot be undone. Please make sure to manage all repeatable campaigns in the repeatable campaign manager in the mailchimp dashboard before manually running these builds.</b></p>
<br/><br/>
<?php $this->load->view("partial/footer"); ?>