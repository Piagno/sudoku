<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Piagno Sudoku</title>
		<meta name="description" content="Sudoku Game with a Generator and Solver.">
		<script>
			window.onload = ()=>{
				statusElement = document.getElementById('status')
				sudoku = new Sudoku('sudoku')
			}
			class Sudoku {
				constructor(id){
					this.playingfield = document.getElementById(id)
					this.playingfield.onkeydown = (e)=>{
						let number = e.key
						let currentField = document.activeElement
						if(number > 0 && number <= 9){
							currentField.innerText = number
							this.setField(currentField.id,number)
						}
						if(number == "Delete"){
							currentField.innerHTML = '&nbsp;'
							this.setField(currentField.id,'')
						}
					}
					this.fields = {1:"",2:"",3:"",4:"",5:"",6:"",7:"",8:"",9:"",10:"",11:"",12:"",13:"",14:"",15:"",16:"",17:"",18:"",19:"",20:"",21:"",22:"",23:"",24:"",25:"",26:"",27:"",28:"",29:"",30:"",31:"",32:"",33:"",34:"",35:"",36:"",37:"",38:"",39:"",40:"",41:"",42:"",43:"",44:"",45:"",46:"",47:"",48:"",49:"",50:"",51:"",52:"",53:"",54:"",55:"",56:"",57:"",58:"",59:"",60:"",61:"",62:"",63:"",64:"",65:"",66:"",67:"",68:"",69:"",70:"",71:"",72:"",73:"",74:"",75:"",76:"",77:"",78:"",79:"",80:"",81:""}
				}
				setField(number,value){
					this.fields[number] = value
				}
				getColumn(column){
					let baseIndex = [0,9,18,27,36,45,54,63,72]
					let values = []
					baseIndex.forEach((i)=>{
						let field = i + column
						let value = this.fields[field]
						values.push({field: field, value: value})
					})
					return values
				}
				getRow(row){
					let firstField = row * 9 - 8
					let values = []
					for(let i=firstField;i<firstField+9;i++){
						let value = this.fields[i]
						values.push({field: i, value: value})
					}
					return values
				}
				getLargeField(lField){
					let baseIndex = [1,4,7,28,31,34,55,58,61]
					let firstField = baseIndex[lField - 1]
					return [
						{field: firstField, value: this.fields[firstField]},
						{field: firstField + 1, value: this.fields[firstField + 1]},
						{field: firstField + 2, value: this.fields[firstField + 2]},
						{field: firstField + 9, value: this.fields[firstField + 9]},
						{field: firstField + 10, value: this.fields[firstField + 10]},
						{field: firstField + 11, value: this.fields[firstField + 11]},
						{field: firstField + 18, value: this.fields[firstField + 18]},
						{field: firstField + 19, value: this.fields[firstField + 19]},
						{field: firstField + 20, value: this.fields[firstField + 20]}
					]
				}
				checkGroup(type,index){
					let result = true
					let values = []
					switch(type){
						case "column":
							values = this.getColumn(index)
							break;
						case "row":
							values = this.getRow(index)
							break;
						case "largeField":
							values = this.getLargeField(index)
							break;
						default:
							result = false
							break;
					}
					values.forEach((value)=>{
						if(value.value == ""){
							result = false
						}
						let filtered = values.filter((toCheck)=>{
							if(value.value == toCheck.value){
								return toCheck
							}else{
								return false
							}
						})
						if(filtered.length != 1){
							result = false
						}
					})
					if(values.length == 0){
						result = false
					}
					return result
				}
				check(){
					let result = true
					if(this.checkGroup("column",1) == false){result = false}
					if(this.checkGroup("column",2) == false){result = false}
					if(this.checkGroup("column",3) == false){result = false}
					if(this.checkGroup("column",4) == false){result = false}
					if(this.checkGroup("column",5) == false){result = false}
					if(this.checkGroup("column",6) == false){result = false}
					if(this.checkGroup("column",7) == false){result = false}
					if(this.checkGroup("column",8) == false){result = false}
					if(this.checkGroup("column",9) == false){result = false}
					if(this.checkGroup("row",1) == false){result = false}
					if(this.checkGroup("row",2) == false){result = false}
					if(this.checkGroup("row",3) == false){result = false}
					if(this.checkGroup("row",4) == false){result = false}
					if(this.checkGroup("row",5) == false){result = false}
					if(this.checkGroup("row",6) == false){result = false}
					if(this.checkGroup("row",7) == false){result = false}
					if(this.checkGroup("row",8) == false){result = false}
					if(this.checkGroup("row",9) == false){result = false}
					if(this.checkGroup("largeField",1) == false){result = false}
					if(this.checkGroup("largeField",2) == false){result = false}
					if(this.checkGroup("largeField",3) == false){result = false}
					if(this.checkGroup("largeField",4) == false){result = false}
					if(this.checkGroup("largeField",5) == false){result = false}
					if(this.checkGroup("largeField",6) == false){result = false}
					if(this.checkGroup("largeField",7) == false){result = false}
					if(this.checkGroup("largeField",8) == false){result = false}
					if(this.checkGroup("largeField",9) == false){result = false}
					return result
				}
				clear(){
					for(let i=1;i<=81;i++){
						this.setField(i,"")
						document.getElementById(i).innerHTML = "&nbsp;"
					}
				}
				getPossibleValues(field){
					let possibleValues = [1,2,3,4,5,6,7,8,9]
					let column = field % 9
					if(column == 0){column = 9}
					let blockedValues = this.getColumn(column)
					let row = Math.ceil(field / 9)
					blockedValues = blockedValues.concat(this.getRow(row))
					let largeColumn = Math.ceil(column / 3)
					let largeRow = Math.ceil(row /3)
					let largeField = 1
					if(largeColumn * largeRow != 1){
						largeField = ((largeRow * largeColumn) + Math.pow(largeRow,2)) / 3 + largeRow
					}
					blockedValues = blockedValues.concat(this.getLargeField(largeField))
					let filteredBlockedValues = blockedValues.filter((blockedValue)=>{if(blockedValue.value != ""){return blockedValue}})
					filteredBlockedValues.forEach((blockedValue)=>{
						let index = possibleValues.indexOf(parseInt(blockedValue.value))
						if(index != -1){
							possibleValues.splice(index,1)
						}
					})
					return possibleValues
				}
				solve(){
					let solvable = true
					let history = []
					let rounds = 0
					let rollbacks = 0
					let startTime = Date.now()
					while(this.check() == false && solvable){
						rounds++
						let lowestCandidates = 0
						let lowestCandidatesField = 0
						for(let i=1;i<=81;i++){
							let field = {field: i,value: this.fields[i]}
							if(field.value == ""){
								let possibleValues = this.getPossibleValues(field.field)
								if(lowestCandidates == 0){
									lowestCandidates = possibleValues
									lowestCandidatesField = field.field
								}else{
									if(lowestCandidates.length > possibleValues.length){
										lowestCandidates = possibleValues
										lowestCandidatesField = field.field
									}
								}
							}
						}
						if(lowestCandidates != 0){
							if(lowestCandidates.length == 1){
								history.push({field:lowestCandidatesField, value: lowestCandidates[0], assumed: false})
							}else{
								let otherPossibilities = JSON.parse(JSON.stringify(lowestCandidates))
								otherPossibilities.splice(0,1)
								history.push({field:lowestCandidatesField, value: lowestCandidates[0], assumed: true, otherPossibilities: otherPossibilities})
							}
							document.getElementById(lowestCandidatesField).innerText = lowestCandidates[0]
							this.setField(lowestCandidatesField,lowestCandidates[0])
						}else{
							let rollbacking = true
							rollbacks++
							while(rollbacking){
								if(history.length != 0){
									let rollbackField = JSON.parse(JSON.stringify(history[history.length - 1]))
									if(rollbackField.assumed){
										if(rollbackField.otherPossibilities.length == 1){
											rollbackField.assumed = false
										}
										this.setField(rollbackField.field, rollbackField.otherPossibilities[0])
										document.getElementById(rollbackField.field).innerText = rollbackField.otherPossibilities[0]
										history.splice(history.length - 1,1)
										let otherPossibilities = JSON.parse(JSON.stringify(rollbackField.otherPossibilities))
										otherPossibilities.splice(0,1)
										history.push({field: rollbackField.field, value: rollbackField.otherPossibilities[0], assumed: rollbackField.assumed, otherPossibilities: otherPossibilities})
										rollbacking = false
									}else{
										this.setField(rollbackField.field, '')
										document.getElementById(rollbackField.field).innerHTML = '&nbsp;'
										history.splice(history.length - 1,1)
									}
								}else{
									solvable = false
									rollbacking = false
								}
							}
						}
					}
					console.log("Rounds: "+rounds)
					console.log("Rollbacks: "+rollbacks)
					console.log("Took: "+(Date.now() - startTime)+"ms")
					return solvable
				}
			}
			checkSudoku = ()=>{
				statusElement.innerText = 'Checking Sudoku...'
				if(sudoku.check()){
					statusElement.innerText = 'All good, Horray!'
				}else{
					statusElement.innerText = 'Something is wrong :('
				}
				setTimeout(function(){statusElement.innerText = ''}, 3000)
			}
			generateSudoku = ()=>{
				//GENERATE
			}
			solveSudoku = ()=>{
				statusElement.innerText = 'Solving...'
				let solved = sudoku.solve()
				if(solved){
					statusElement.innerText = 'Solved'
				}else{
					statusElement.innerText = 'Not solvable'
				}
				setTimeout(function(){statusElement.innerText = ''}, 3000)
			}
			clearSudoku = ()=>{
				statusElement.innerText = 'Clearing...'
				sudoku.clear()
				statusElement.innerText = 'Cleared'
				setTimeout(function(){statusElement.innerText = ''}, 3000)
			}
		</script>
		<style>
			body {
				margin: 0 auto;
				background-color: black;
				color: white;
				font-family: sans-serif;
			}
			#sudoku {
			
			}
			#sudoku > div {
				line-height: 0;
			}
			#sudoku > div > div {
				min-width: 50px;
				min-height: 50px;
				border: 1px solid white;
				display: inline-block;
				text-align: center;
				line-height: 50px;
			}
			#sudoku div:focus{
				border-color: red;
			}
		</style>
	</head>
	<body>
		<h1>Piagno Sudoku</h1>
		<div id="sudoku">
			<div id="l1">
				<div id="1" tabindex="0">&nbsp;</div><div id="2" tabindex="0">&nbsp;</div><div id="3" tabindex="0">&nbsp;</div><div id="4" tabindex="0">&nbsp;</div><div id="5" tabindex="0">&nbsp;</div><div id="6" tabindex="0">&nbsp;</div><div id="7" tabindex="0">&nbsp;</div><div id="8" tabindex="0">&nbsp;</div><div id="9" tabindex="0">&nbsp;</div>
			</div>
			<div id="l2">
				<div id="10" tabindex="0">&nbsp;</div><div id="11" tabindex="0">&nbsp;</div><div id="12" tabindex="0">&nbsp;</div><div id="13" tabindex="0">&nbsp;</div><div id="14" tabindex="0">&nbsp;</div><div id="15" tabindex="0">&nbsp;</div><div id="16" tabindex="0">&nbsp;</div><div id="17" tabindex="0">&nbsp;</div><div id="18" tabindex="0">&nbsp;</div>
			</div>
			<div id="l3">
				<div id="19" tabindex="0">&nbsp;</div><div id="20" tabindex="0">&nbsp;</div><div id="21" tabindex="0">&nbsp;</div><div id="22" tabindex="0">&nbsp;</div><div id="23" tabindex="0">&nbsp;</div><div id="24" tabindex="0">&nbsp;</div><div id="25" tabindex="0">&nbsp;</div><div id="26" tabindex="0">&nbsp;</div><div id="27" tabindex="0">&nbsp;</div>
			</div>
			<div id="l4">
				<div id="28" tabindex="0">&nbsp;</div><div id="29" tabindex="0">&nbsp;</div><div id="30" tabindex="0">&nbsp;</div><div id="31" tabindex="0">&nbsp;</div><div id="32" tabindex="0">&nbsp;</div><div id="33" tabindex="0">&nbsp;</div><div id="34" tabindex="0">&nbsp;</div><div id="35" tabindex="0">&nbsp;</div><div id="36" tabindex="0">&nbsp;</div>
			</div>
			<div id="l5">
				<div id="37" tabindex="0">&nbsp;</div><div id="38" tabindex="0">&nbsp;</div><div id="39" tabindex="0">&nbsp;</div><div id="40" tabindex="0">&nbsp;</div><div id="41" tabindex="0">&nbsp;</div><div id="42" tabindex="0">&nbsp;</div><div id="43" tabindex="0">&nbsp;</div><div id="44" tabindex="0">&nbsp;</div><div id="45" tabindex="0">&nbsp;</div>
			</div>
			<div id="l6">
				<div id="46" tabindex="0">&nbsp;</div><div id="47" tabindex="0">&nbsp;</div><div id="48" tabindex="0">&nbsp;</div><div id="49" tabindex="0">&nbsp;</div><div id="50" tabindex="0">&nbsp;</div><div id="51" tabindex="0">&nbsp;</div><div id="52" tabindex="0">&nbsp;</div><div id="53" tabindex="0">&nbsp;</div><div id="54" tabindex="0">&nbsp;</div>
			</div>
			<div id="l7">
				<div id="55" tabindex="0">&nbsp;</div><div id="56" tabindex="0">&nbsp;</div><div id="57" tabindex="0">&nbsp;</div><div id="58" tabindex="0">&nbsp;</div><div id="59" tabindex="0">&nbsp;</div><div id="60" tabindex="0">&nbsp;</div><div id="61" tabindex="0">&nbsp;</div><div id="62" tabindex="0">&nbsp;</div><div id="63" tabindex="0">&nbsp;</div>
			</div>
			<div id="l8">
				<div id="64" tabindex="0">&nbsp;</div><div id="65" tabindex="0">&nbsp;</div><div id="66" tabindex="0">&nbsp;</div><div id="67" tabindex="0">&nbsp;</div><div id="68" tabindex="0">&nbsp;</div><div id="69" tabindex="0">&nbsp;</div><div id="70" tabindex="0">&nbsp;</div><div id="71" tabindex="0">&nbsp;</div><div id="72" tabindex="0">&nbsp;</div>
			</div>
			<div id="l9">
				<div id="73" tabindex="0">&nbsp;</div><div id="74" tabindex="0">&nbsp;</div><div id="75" tabindex="0">&nbsp;</div><div id="76" tabindex="0">&nbsp;</div><div id="77" tabindex="0">&nbsp;</div><div id="78" tabindex="0">&nbsp;</div><div id="79" tabindex="0">&nbsp;</div><div id="80" tabindex="0">&nbsp;</div><div id="81" tabindex="0">&nbsp;</div>
			</div>
		</div>
		<div id="controls">
			<div><button type="button" onclick="checkSudoku()">Check</button></div>
			<div><button type="button" onclick="generateSudoku()">Generate</button></div>
			<div><button type="button" onclick="solveSudoku()">Solve</button></div>
			<div><button type="button" onclick="clearSudoku()">Clear</button></div>
			<div id="status"></div>
		</div>
	</body>
</html>
