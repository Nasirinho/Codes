
public class LinkedList<I extends Comparable<? super I>> implements ListInterface<I>{
	
	private LinkedListNode<I> head;
	private int size;
	
	
	public LinkedList() {
		this.head = null;
		this.size = 0;
	}

	@Override
	public ListInterface<I> copy() {
		LinkedList<I> copy = new LinkedList<>();
        LinkedListNode<I> currentElement = head;
        while (currentElement != null) {
            copy.add(currentElement.getElement());
            currentElement = currentElement.getNext();
        }
        return copy;

	}
	

	@Override
	public int size() {
		
		return this.size;
	}

	@Override
	public boolean isEmpty() {
		
		return this.size == 0;
	}

	@Override
	public void add(I element) {
		
		this.add(element, size);
		
	}

	@Override
	public void add(I element, int index) throws IndexOutOfBoundsException {
		if (index < 0 || index > size) {
            throw new IndexOutOfBoundsException("Invalid index: " + index);
        }
        if (element == null) {
    	    throw new NullPointerException("Cannot add null element to the list.");
    	}
        
        LinkedListNode<I> newLinkedListNode = new LinkedListNode<>(element);

        if (index == 0) {
        	newLinkedListNode.setNext(head);
            head = newLinkedListNode;
        } else {
        	LinkedListNode<I> currentElement = head;
            for (int i = 0; i < index - 1; i++)
                currentElement = currentElement.getNext();

            newLinkedListNode.setNext(currentElement.getNext());
            currentElement.setNext(newLinkedListNode);
        }

        size++;
    }

        	
	
	@Override
	public I get(int index) throws IndexOutOfBoundsException {
		if (index < 0 || index >= size) throw new IndexOutOfBoundsException("Invalid index: " + index);

        LinkedListNode<I> currentElement = head;
        
        for (int i = 0; i < index; i++)
            currentElement = currentElement.getNext();

        return currentElement.getElement();

	}

	@Override
	public I replace(I element, int index) throws IndexOutOfBoundsException {
		if (index < 0 || index >= size) throw new IndexOutOfBoundsException("Invalid index: " + index);
		LinkedListNode<I> currentElement = head;
		for (int i = 0; i < index; i++) {
			currentElement = currentElement.getNext();
		}
		
		I old = currentElement.getElement();
		currentElement.setElement(element);
		
		return old;
	}

	@Override
	public I remove(int index) throws IndexOutOfBoundsException {
		if (index < 0 || index >= size) throw new IndexOutOfBoundsException("Invalid index: " + index);

        I removed;

        if (index == 0) {
            removed = head.getElement();
            head = head.getNext();
        } else {
            LinkedListNode<I> currentElement = head;
            for (int i = 0; i < index - 1; i++)
                currentElement = currentElement.getNext();

            LinkedListNode<I> toRemove = currentElement.getNext();
            removed = toRemove.getElement();
            currentElement.setNext(toRemove.getNext());
        }

        size--;
        return removed;
	}

	@Override
	public void removeAll() {
		head = null;
        size = 0;

		
	}

}
