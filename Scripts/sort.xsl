<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output indent="yes"/>
  <xsl:strip-space elements="*"/>
<xsl:template match="/">
	<checklist>
	
		<!-- Store category name in variable and set-up each category with sub elements -->
		<xsl:for-each select="checklist/category">
			<xsl:sort select="@name"/>
			<xsl:variable name="catName">
				<xsl:value-of select="@name"/>
			</xsl:variable>
			<category name="{$catName}">
			
				<!-- Store rule name in variable and set-up each rule with sub elements -->
				<xsl:for-each select="rule">
					<xsl:sort select="@name"/>
					<xsl:variable name="ruleName">
						<xsl:value-of select="@name"/>
					</xsl:variable>
					<rule name="{$ruleName}">						
						
						<!-- Store link url in variable and set-up each link with sub elements -->
						<xsl:for-each select="link">
							<xsl:sort select="."/>
							<xsl:variable name="url">
								<xsl:value-of select="@url"/>
							</xsl:variable>
							<xsl:variable name="linkText">
								<xsl:value-of select="."/>
							</xsl:variable>
							<link url="{$url}">						
								<xsl:copy-of select="$linkText" />						
							</link>
						</xsl:for-each>				
						<!-- End -->
						
					</rule>
				</xsl:for-each>
				<!-- End -->
				
			</category>
		</xsl:for-each>
		
		<!-- End -->
	</checklist>
</xsl:template>

</xsl:stylesheet>
