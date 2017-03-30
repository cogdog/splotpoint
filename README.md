# Splotpoint
by Alan Levine http://cog.dog/ or http://cogdogblog.com/

A Wordpress-theme *SPLOT* for presenting the Cool Way (on the web)


![](images/splotpoint-demo.jpg "Splotpoint Demo")

## What is this?
This Wordpress Theme powers a site that can be used to deliver presentations on the web, without any residue of commercial slideware. Your presentations not only look good, they also become the reference resource (e.g. additional links and info)

I developed a series of custom sites like this initially [while on a fellowship](http://cogdog.trubox.ca) at [Thompson Rivers University](http://tru.ca/) and has now been generalized as part of the collection of [SPLOT tools](http://splot.ca/).

## See It In Action

* [Content With Content](http://show.cogdog.casa/tru-content/) - a presentation at Thompson Rivers University where I bragged about sharing this SPLOT

And if you make your own SplotPoint, please please pretty please fork this repo to edit this Readme with a link to your spiffy example

If you have problems, feature suggestions, small bags of gold coin for me, please [contact me via the issues area](https://github.com/cogdog/splotpoint/issues) on this repo.

## Requirements

I will make a grand assumptive leap in that you have a self hosted Wordpress site and can install themes. Splotpoint is a child theme based on [Intergalactic Theme](https://wordpress.org/themes/intergalactic).


## Setting Up SplotPoint 

(1) Create a fresh Wordpress site.

(3) Install the [Intergalactic theme](https://wordpress.org/themes/intergalactic) directly from the Wordpress dashboard

(4) Install the SplotPoint theme downloaded from this repo as a .zip file; either by uploading to your wp-content/themes directory or by direct FTPing the unzipped files to your wordpress `wp-content/theme`s directory.

(5) Activate SplotPoint as the site's theme. 

The new site will be pretty plain, Jane. Hang on.

![](images/splotpoint-new.jpg "New SPLOTpoint")


## Making Slides

In this theme Wordpress `Posts` are renamed `Slides` -- create maybe 2,3 new ones. In the Post Editor, add your title, a featured image, and use the `Slide Attribute` box on the right to designate the order your slide sits in the deck (this can be edited easily later).

![](images/slide-attributes.jpg.jpg "Slide Attributes")

For the body text of all slides, any headings will be center aligned by default.

In the Slides (Posts) view they are listed in order of the Slide Attribute.
 
![](images/splotpoint-slides.jpg "Slide Listings")

You can quickly modify titles and slide order via the 'Quick Edit" link that appears when you hover over a slide title.

## Customizing the Slide deck
Once you have 3 or more slides, you can "pretty" things in the Wordpress Customizer (via the `Customize` link in the Admin toolbar while viewing the site or under `Appearance - Customize` in the Wordpress Dashboard.

When the Customizer launches, click the `SPLOTPoint Prettify section`

![](images/customizer1.jpg "Customizer First View")

For the Site title, you can add an image to use as a backdrop, plus change the colors of the show title and the subtitle 

![](images/title-stuff.jpg "Prettifying the title")

You should see changes as you choose colors (or upload a new image).

Now in the right side click the title of the top "Slide" (aka Post) to open it, and scroll to the bottom.

Here you can edit the color of the buttons and edit the text displayed in the footer.

![](images/buttons.jpg "Prettifying the buttons")

Save your changes. Jump for joy.

## Create a Landing Page

The default of your site is a normal blog post listing. Yecch.

Create a new Wordpress Page that will soon become your landing page. Add a title, a description of your presentation, and a hypertext link that will go to the first slide.

Publish the page.

Now launch the Customizer while this page is in view. Open the section for `Static Front Page` and change the option for Front page displays to be `a static page`. From the Front page menu, select the name of the page you just created.

Click `Save & Publish` and marvel at your slick Splotpoint. 








