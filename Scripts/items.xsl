<!--  Creates index.html file using items.xsl from script folder -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:template match="/">
		<html>
			<body>					
				<xsl:for-each select="checklist/category">
					<section>
						<h2><xsl:value-of select="@name"/></h2>
						<ul>
							<xsl:for-each select="rule">
								<!--  Variable storing rule name  -->
								<xsl:variable name="ruleName">
									<xsl:value-of select="@name"/>
								</xsl:variable>
								
								<!--  List containing the rules  -->
								<li>
									<input type="checkbox" class="listCheck" id="{$ruleName}" tabindex="1" onchange='handleChange(this);' />
									<label class="customlabel" for="{$ruleName}"><xsl:copy-of select="$ruleName" /></label>
									<em class="info" onClick="openDetails(event); return false;" >i</em>
										<!--  Sub list holding links and their urls  -->
										<ul>
											<xsl:for-each select="link">
												<!--  Variable storing link -->
												<xsl:variable name="linkUrl">
													<xsl:value-of select="@url"/>
												</xsl:variable>
												
												<!--  List of links in the rule  -->
												<li>
													<a class="linktext" href="{$linkUrl}"><xsl:value-of select="." /></a>
												</li>
											</xsl:for-each>
										</ul>
								</li>	
							</xsl:for-each>
						</ul>						
					</section>
				</xsl:for-each>				
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>