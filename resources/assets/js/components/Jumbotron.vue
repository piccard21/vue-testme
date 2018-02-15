<template>
	<div class="jumbotron jumbotron-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col text-left ml-4">
					<h1 class="display-4">{{header}}</h1>
					<p class="lead">{{subheader}}</p>
				</div>
				<div class="col-2 text-right mr-4">
					<img class="mr-3"
					     src="data:image/webp;base64,UklGRoYFAABXRUJQVlA4THkFAAAvt0AOEP+ioG0bxuDKn9IuCIFAkr/nHAsEkiD2V51h2zaO/uOWgt9/3F8HPPU/AEIQeAAQAkEIAGAQAGEAhRe4DgShgNugIBCFYFAwGoWAIPKqAACAqQeEQRBEIABC4/Bh0DCCRTA4GIOBsfhwGCwaiwFt27ZdJdZcZDAgSrgSjloYigKUaMTjNuecE/7/d+y11wlUnXYfI/o/AQiSJ0Nl/jmHqxYZKwiYVwL1deDGpG1oInA+CdSLC9F14jeiwWP/Q6BunDWIt9MIoGdDwc+ZkxIZ5xFIrwXqc182vmtYCwUTPAvUsyjSJ34zjoB68ClQV5IaGafBN9nsX2S+aUwYqk097R+c/wiGJ6YCGRdhJNb6izTJuGBokZ7zEW4F6mOfSw0M7fA/YH108CpQj0y4S/x2Aj6LZEeBpn0Vy4gOvwTqUlsmYw7+ile3eyNR99HY7926CBd7guExkCXjCnw1XreJRmM36pepVSJygDuBekdk29AN+ypN+mhQ2Sdl0p3gTaAesMINUvBVZpQ6PrHcOfoWqItwlyngX2BrND5CuNgTfB+ldojoD9xLW3oGY0utXmdlQstaK8ymZZW45Fyj0+u1aoWIIWbpGUTKzc6kqcksuZKurnZ7vbXlmRBTsJpMx7LyMjwI1BvyRP2IB79IXy7bxP4C0CThhhb5Q+btMjdB+vLYBhFlTKUtbSvsLNUmcz+j9UjYcoB3gbrDyu44POuSedaFSIfEVVFtnWTFZY1yjsa2SGpnPToeCvYuwll4R7Rr6LmwQqzN0bRkQE4mmFVHHWJthrZj3uBSoL4O4YcCYi3GDmG6uMhsFIt5IGZr9mw4ssy0JLwEPc2OO8iSvplGYk2jKpAtNph2sTjjCE8C9eKHFoAphqIAMkwP+izpNQDoaxSX9Rv1McmcRnMOaswsgLit9QHAYupwcf9DcuuH3wBibtWYnLbCZCU7M2BNcVvrO+gzMQDoahT15lEJXxHzwTKAkFttZkKbY+YlJTjBmkZpUcjWBtBXmbQnl0r4dTi5lfQH3Ooz6Wg0Gp1nliURZ3mmJoqTvhPVubwXx0PBz3l0nTrhUdpixH8EO3AW3tF2IpIUIy95sP+uhHdoEtHiKO04qws2XEBNo1nJhK8elPANFunT/4w00/Km6N6lEn4dpW1mMz5q80XhlDfoa7QhGGN2i9KUa8ffgr0L9IlfG50NZgIOvZhneC3J7MCpO+9KeA9UDDQ3Ml0mrcWSetSjhKMIYzOJpB5260EJ3wCgabAnR2WVyWtN0i2P0HKCHY3i2hbpky5d7Am+j7ToJkfrkRGpMktal8l5NeuoxWQBRGwmJmhIjr6Vee8C7JTNUcN3O2FthtmMAOOk21GvIgMnVWYNQIn0HgBUmK7kTQnvYVwwUMk/4wy1F0pAeEujVra4zjThFepOxhmqzcwNGEvLMdRcyHP3SvgOc6hlGIz5Bn2GqAWgzJgHY95lnKDBmPthLTpgiOrMxZ7g+1iAxBZHvbBvZmwJGqJBFt6FNpxEe6KNFNiy7OhLCS8hzhpoxTeY7ktQ2TI1x+ADVJ0gsrxrGKzEYJzdlLwp4QMcrhgox2TYhJbM6Cktw4YZYKJQKRcmGYSn52v12tJ/CRgjGT1tGs/ocUM0Y4xxQDRf/VOvVbNRSEPpglUujAO4U8L3fSfhrmE7oQXM8z3B8BiOxwYctUOB4/BLCS/h4qyBfgWOVyV8hKsNgz0VMG6V8GPfncg6R5uxQHH+IxiewOVJm6PVQPH6KbyC65aBKgHi5FS4Dw8LRb4QHG6U8MOT4Hn2IxieIkAffCrhNYL0sxI+I0hfK+HnQZDaf3kTnuF/8PsX4VWgulLCz4MgdToU/JwjQO9/KOEt/AwA"
					     alt="InterNetX Logo" id="logo">
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	export default {
		props: ['header', 'subheader'],
		data() {
			return {};
		}
	};
</script>