<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VCM Presentation</title>
    <link rel="stylesheet" type="text/css" href="style.css">

	<!--
		File: presentation.php - Presentation page
		Contributors: James West - westj4@csp.edu
		Course: CSC235 Server-Side Development
		Assignment: Individual Project - Week 4
		Date: 4/10/23
	-->
</head>

<body>
    <header>
        <h1>Version Control Management Presentation</h1>
        <nav><a href="presentation.php">Home</a><a href="index.php">App</a></nav>
    </header>
    <main>
        <h3>The Problem</h3>
        <p>
            James and Dylan are working together on a group project for their CS class and have made a great team,
            however, they are experiencing issues populating changes made to the project accross various local and
            production environments. 
        </p>
        <p>
            Their initial quick solution was to use a shared drop box as the place to share changes. James and Dylan
            are storing the code in other folders on their local devices while developing and then posting changes to
            seperate production servers as well. This means that even small changes must be populated accross 5 
            locationsby two seperate people (James does not have access to Dylan's personal or prod env and vice versa).
        </p>
        <h3>Q&A</h3>

        <div class="q-and-a">
            <p class="question">What are the technical specifications local and production environments?</p>
            <p class="answer">
                We are both using the AMPPS stack on a Windows machine for our local development environment. AMPPS likes
                the files to be posted in a very specific directory. Dylan is using an ESXI he owns to host his projects.
                James is using an AWS LightSail Cloud Linux Server to host his projects. 
            </p>
        </div>
        <div class="q-and-a">
            <p class="question">What version control technologies are James and Dylan familiar with or willing to 
                learn?
            </p>
            <p class="answer">
                We both have a little experience using git, but are very rusty. Seeing as git is standard 
                in the industry they are hoping to work in, they would be very willing to learn.
            </p>
        </div>
        <div class="q-and-a">
            <p class="question">Would consolidation to 1 production environment be acceptable?</p>
            <p class="answer">Yes, we have been considering consolidating to one "main" production enviroment.</p>
        </div>
        <div class="q-and-a">
            <p class="question">
                If so, whose production environment would be used and how important is it that both developers be able to post changes to this environment?
            </p>
            <p class="answer">
                We have been discussing using James' production server as the "main" server. It is very important that both developers be able to make changes. 
                Preferrably, this would be done without Dylan having to ssh to James' cloud server. 
            </p>
        </div>
        <div class="q-and-a">
            <p class="question">
                If you could wake up tomorrow and a miracle happened that solved this problem, what might that look 
                like?
            </p>
            <p class="answer">
                We would be able to populate changes made to code accross all enviroments easily. Ideally, we would want to maintain two code bases. One for the 
                production server that is "production ready code". Another for being able to make potentially breaking changes while still developing. It would 
                be nice to have some sort of "easy" button that both Dylan and James could use to deploy changes made to the development base to the production server. 
                Also, it would be nice to have a history of changes made in case they need to be reverted. 
            </p>
        </div>
        <h3>Soultion Brainstorming</h3>
        <p>
            First, replacing drop-box as means of sharing code seems key. They mentioned learning git, a shared remote git repository would allow changes to be populated 
            accross both local environments. There are other alternatives to git which could be considered as well. As far deploying changes to the server, there are a 
            few ways this could be accomplished. One would be that, when the code is ready, they simply ftp to the server and manually populate it with the changes. 
            Dylan would need ftp access to the server to be able to do this, but that would be an easy problem to solve. Another solution would be to deploy git on the 
            server as well which could be updated via git commands run through the terminal. In either case, the problem of needing to manage two code bases 
            (one for development and one for production) could be solved by using two git branches. This solution would involve commitment on the part of Derek and Dylan 
            to the process of learning git (at least some basic git commands). 
        </p>
        <p>
            The version of this solution which involves ftp would be easier to implement and would solve the problem of both developers being able to deploy changes to 
            the server. This could be a good option.
        </p>
        <p>
            The version of this solution which involves using git on the server itself comes with the challenge of providing Dylan with the ability to deploy changes 
            to the server. This, however, could be overcome through the idea of an "easy" button, which would use php to run a script to deploy changes to the server 
            using git.
        </p>
        <p>
            One other solution to consider would be to use the server as the source of sharing changes. The server could host the project in two folders, live and 
            development to allow changes to be tested in the development folder before being pushed to the live folder. FTP would be the means of accessing this. This is 
            similar to the drop-box solution currently implemented, but would have the slight advantage of not conslidation. This is also the easiest solution to implement 
            as it involves low commitment from Dylan and Derek to learn new technologies.
        </p>
        <h3>Recommendation</h3>
        <p>
            My recommendation is to use a remote git repository to manage changes made across all three environments. There would be some upfront work and learning, but I 
            believe this would save time in the long run and be benificial to James and Dylan in their future careers. James (myself) has also expressed a willingness to take 
            the lead on setting this up. Using git for local servers and ftp for the production server may be the easiest solution in the short term. However, an easy button, 
            which would auto-deploy changes to the prod server would be super nice, allowing Dylan and James both to deploy code to the server conveniently. This has the 
            additional side-benefit of allowing the repo to be cloned on Dylan's production server, if that is desired down the road.
        </p>
        <img src="graphic/systemDesign.jpg" alt="System Design diagram" width="1000px">
    </main>
</body>
</html>