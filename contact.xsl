<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <!-- Include Bootstrap stylesheet -->
  <xsl:variable name="bootstrap_css">https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css</xsl:variable>

  <!-- Match the root element 'contacts' -->
  <xsl:template match="/contacts">
    <html>
      <head>
        <title>Contact List</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="{$bootstrap_css}" />
      </head>
      <body>
        <div class="container">
          <div class="row mt-3">
            <div class="col">
              <a href="gobackadmin.html" class="btn btn-primary">Back</a>
              <select id="sortSelect" class="form-control ml-2" style="width: auto; display: inline-block;">
                <option value="asc">Sort by Date Ascending</option>
                <option value="desc">Sort by Date Descending</option>
              </select>
            </div>
          </div>
          <h2 class="mt-3">Messages</h2>
          <div id="contacts-container">
            <!-- Apply template for each 'contact' element -->
            <xsl:apply-templates select="contact" />
          </div>
        </div>
        <!-- Include Bootstrap JS and additional JS for sorting -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            function sortContacts(order) {
              var container = document.getElementById('contacts-container');
              var contacts = Array.prototype.slice.call(container.getElementsByClassName('contact-card'));
              
              contacts.sort(function(a, b) {
                var dateA = new Date(a.getAttribute('data-date'));
                var dateB = new Date(b.getAttribute('data-date'));
                return (order === 'asc' ? dateA - dateB : dateB - dateA);
              });
              
              contacts.forEach(function(contact) {
                container.appendChild(contact);
              });
            }

            document.getElementById('sortSelect').addEventListener('change', function() {
              var order = this.value;
              sortContacts(order);
            });
          });
        </script>
      </body>
    </html>
  </xsl:template>

  <!-- Match 'contact' elements -->
  <xsl:template match="contact">
    <div class="card mt-3 contact-card" data-date="{date}">
      <div class="card-header d-flex justify-content-between bg-dark text-light">
        <span>Contact ID: <xsl:value-of select="@id" /></span>
        <span>Date: <xsl:value-of select="date" /></span>
      </div>
      <div class="card-body">
        <h5 class="card-title">Name: <xsl:value-of select="name" /></h5>
        <p class="card-text"><strong>Email: </strong> <xsl:value-of select="email" /></p>
        <p class="card-text"><strong>Message: </strong> <xsl:value-of select="message" /></p>
      </div>
    </div>
  </xsl:template>

</xsl:stylesheet>
