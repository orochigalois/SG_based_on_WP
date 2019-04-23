<?php
the_post();
get_header(); 
?>

<div class="container">
	<?php the_content(); ?>

	<div id="styleguide"">

		<h1>Style Guide</h1>

		<section>

			<h2>Key settings</h2>

			<h3>Fonts</h3>
			<ul id="fonts">
				<li class="heading"><strong>Heading Font Family: </strong></li>
				<li class="body"><strong>Base Font Family: </strong></li>
			</ul>

			<h3>Breakpoints</h3>
			<ul id="breakpoints">
				<li class="sm"><strong>Small: </strong> </li>
				<li class="md"><strong>Medium: </strong> </li>
				<li class="lg"><strong>Large: </strong> </li>
				<li class="xl"><strong>XLarge: </strong> </li>
			</ul>

			<h3>Colours</h3>
			<ul id="colors" class="row">
				<li class="primary col-sm-12 col-md-6">Primary colour</li>
				<li class="secondary col-sm-12 col-md-6">Secondary colour</li>
				<li class="success col-sm-6 col-md-3">Success colour</li>
				<li class="danger col-sm-6 col-md-3">Danger colour</li>
				<li class="warning col-sm-6 col-md-3">Warning colour</li>
				<li class="info col-sm-6 col-md-3">Info colour</li>
				<li class="light col-sm-6 col-md-4">Light colour</li>
				<li class="dark col-sm-6 col-md-4">Dark colour</li>
				<li class="body col-sm-6 col-md-4">Body text colour</li>
			</ul>

		</section>

		<section>
			<h2>Buttons</h2>
			<button type="button" class="btn btn-primary">Primary</button>
			<button type="button" class="btn btn-secondary">Secondary</button>
			<button type="button" class="btn btn-success">Success</button>
			<button type="button" class="btn btn-danger">Danger</button>
			<button type="button" class="btn btn-warning">Warning</button>
			<button type="button" class="btn btn-info">Info</button>
			<button type="button" class="btn btn-light">Light</button>
			<button type="button" class="btn btn-dark">Dark</button>
			<button type="button" class="btn btn-link">Link</button>
		</section>

		<!--
		<section>
			<h2>Pagination</h2>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item"><a class="page-link" href="#">Previous</a></li>
					<li class="page-item"><a class="page-link" href="#">1</a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">Next</a></li>
				</ul>
			</nav>
		</section>

		<section>
			<h2>Modals</h2>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Launch demo modal
			</button>
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							...
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		-->

		<section>
			<h2>General Typography</h2>
			<p>A lifetime of working with nuclear power has left me with a healthy green glow…and left me as impotent as a Nevada boxing commissioner. Oh, so
				they have Internet on computers now! That's why I love elementary school, Edna. The children believe anything you tell them. Inflammable means
				flammable? What a country. </p>
			<p>Inflammable means flammable? What a country.How is education supposed to make me feel smarter? Besides, every time I learn something new, it pushes some old stuff out of my brain. Remember when I took that home winemaking course, and I forgot how to drive?</p>

			<h3>Heading 3</h3>
			<p>Last night's "Itchy and Scratchy Show" was, without a doubt, the worst episode *ever.* Rest assured, I was on the Internet within minutes, registering my disgust throughout the world.</p>
			<ul>
				<li>Lisa, vampires are make-believe, like elves, gremlins, and Eskimos.</li>
				<li>Uh, no, you got the wrong number. This is 9-1...2. </li>
				<li>Facts are meaningless. You could use facts to prove anything that's even remotely true!</li>
			</ul>

			<h4>Heading 4</h4>
			<p>Last night's "Itchy and Scratchy Show" was, without a doubt, the worst episode *ever.* Rest assured, I was on the Internet within minutes, registering my disgust throughout the world.</p>
			<ol>
				<li>Uh, no, you got the wrong number. This is 9-1...2. </li>
				<li>Lisa, vampires are make-believe, like elves, gremlins, and Eskimos.</li>
				<li>Facts are meaningless. You could use facts to prove anything that's even remotely true!</li>
			</ol>

			<p>Dear Mr. President, There are too many states nowadays. Please, eliminate three. P.S. I am not a crackpot. Brace yourselves gentlemen. According to the gas chromatograph, the secret ingredient is… Love!? Who's been screwing with this thing?</p>

			<h2>Tables</h2>
			<table>
				<thead>
					<tr>
						<th>Table Header</th>
						<th>Table Header</th>
						<th>Table Header</th>
						<th>Table Header</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Content Goes Here</td>
						<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
						<td>Content Goes Here</td>
						<td>Content Goes Here</td>
					</tr>
					<tr>
						<td>Content Goes Here</td>
						<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
						<td>Content Goes Here</td>
						<td>Content Goes Here</td>
					</tr>
					<tr>
						<td>Content Goes Here</td>
						<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
						<td>Content Goes Here</td>
						<td>Content Goes Here</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
					<th>Table Footer</th>
					<th>Table Footer</th>
					<th>Table Footer</th>
					<th>Table Footer</th>
				</tr>
			</tfoot>
		</table>
		</section>

		<section>
			<h2>Forms</h2>
			<form>j
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputEmail4">Email</label>
						<input type="email" class="form-control" id="inputEmail4" placeholder="Email">
					</div>
					<div class="form-group col-md-6">
						<label for="inputPassword4">Password</label>
						<input type="password" class="form-control" id="inputPassword4" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<label for="inputAddress">Address</label>
					<input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
				</div>
				<div class="form-group">
					<label for="inputAddress2">Address 2</label>
					<input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="inputCity">City</label>
						<input type="text" class="form-control" id="inputCity">
					</div>
					<div class="form-group col-md-4">
						<label for="inputState">State</label>
						<select id="inputState" class="form-control">
							<option selected>Choose...</option>
							<option>...</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<label for="inputZip">Zip</label>
						<input type="text" class="form-control" id="inputZip">
					</div>
				</div>
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="gridCheck">
						<label class="form-check-label" for="gridCheck">
							Check me out
						</label>
					</div>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
					<label class="form-check-label" for="exampleRadios1">
						Default radio
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
					<label class="form-check-label" for="exampleRadios2">
						Second default radio
					</label>
				</div>
				<div class="form-check disabled">
					<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
					<label class="form-check-label" for="exampleRadios3">
						Disabled radio
					</label>
				</div>
				<button type="submit" class="btn btn-primary">Sign in</button>
			</form>
		</section>

		<section>
			<h2>Alerts/Messages</h2>
			<div class="alert alert-primary" role="alert">
				<strong>Primary alert </strong>
				Last night's "Itchy and Scratchy Show" was, without a doubt, the worst episode *ever.* Rest assured, I was on the Internet within minutes, registering my disgust throughout the world.
			</div>
			<div class="alert alert-secondary" role="alert">
				<strong>Secondary alert </strong>
				Facts are meaningless. You could use facts to prove anything that's even remotely true!
			</div>
			<div class="alert alert-success" role="alert">
				<strong>Success alert </strong>
				Lisa, vampires are make-believe, like elves, gremlins, and Eskimos.
			</div>
			<div class="alert alert-danger" role="alert">
				<strong>Danger alert </strong>
				Please do not offer my god a peanut.
			</div>
			<div class="alert alert-warning" role="alert">
				<strong>Warning alert </strong>
				Books are useless! I only ever read one book, "To Kill A Mockingbird," and it gave me absolutely no insight on how to kill mockingbirds! Sure it taught me not to judge a man by the color of his skin…but what good does *that* do me?
			</div>
			<div class="alert alert-info" role="alert">
				<strong>Info alert </strong>
				They only come out in the night. Or in this case, the day.
			</div>
			<div class="alert alert-light" role="alert">
				<strong>Light alert </strong>
				Donuts. Is there anything they can't do?
			</div>
			<div class="alert alert-dark" role="alert">
				<strong>Dark alert </strong>
				Human contact: the final frontier.
			</div>
		</section>

		<section>
			<h2>Accordions</h2>
			<div id="accordion">
				<div class="card">
					<div class="card-header" id="headingOne">
						<h3>
							<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Collapsible Group Item #1
							</button>
						</h3>
					</div>

					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body">
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingTwo">
						<h3>
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Collapsible Group Item #2
							</button>
						</h3>
					</div>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
						<div class="card-body">
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingThree">
						<h3>
							<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Collapsible Group Item #3
							</button>
						</h3>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
						<div class="card-body">
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
			</div>
		</section>

</div>

<?php get_footer(); ?>