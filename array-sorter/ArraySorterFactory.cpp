#include <iostream>
#include "ArraySorterFactory.h"
#include "ArraySorterSelectionSort.h"
#include "ArraySorterInsertionSort.h"
#include "ArraySorterBubbleSort.h"
#include "ArraySorterMergeSort.h"
#include "ArraySorterQuickSort.h"


using namespace std;

unique_ptr<ArraySorter>ArraySorterFactory::createArraySorter(ArraySorterType type, int numberOfElements, int arrayToBeSorted[]){

		switch (type)
		{
		case SelectionSort: return make_unique<ArraySorterSelectionSort>(numberOfElements,arrayToBeSorted);
		case InsertionSort: return make_unique<ArraySorterInsertionSort>(numberOfElements,arrayToBeSorted);
		case BubbleSort:    return make_unique<ArraySorterBubbleSort>(numberOfElements,arrayToBeSorted);
		case MergeSort:    return make_unique<ArraySorterMergeSort>(numberOfElements,arrayToBeSorted);
		case QuickSort:    return make_unique<ArraySorterQuickSort>(numberOfElements,arrayToBeSorted);
		}

	}
